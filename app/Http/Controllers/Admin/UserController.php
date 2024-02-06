<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Interfaces\AuthInterface;
use App\Interfaces\UserInterface;

use App\Models\User;

class UserController extends Controller
{
    // private AuthInterface $authRepository;
    private UserInterface $userRepository;

    // public function __construct(AuthInterface $authRepository, UserInterface $userRepository)
    public function __construct(UserInterface $userRepository)
    {
        // $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = User::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('first_name', 'like', '%'.$keyword.'%')
            ->orWhere('last_name', 'like', '%'.$keyword.'%')
            ->orWhere('email', 'like', '%'.$keyword.'%')
            ->orWhere('mobile_no', 'like', '%'.$keyword.'%')
            ->orWhere('whatsapp_no', 'like', '%'.$keyword.'%')
            ->orWhere('gender', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->latest('id')->paginate(applicationSettings()->pagination_items_per_page);

        return view('admin.user.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'mobile_no' => 'required|integer|digits:10|unique:users,mobile_no',
            'whatsapp_no' => 'nullable|integer|digits:10|unique:users,whatsapp_no',
            'password' => 'required|string|min:2|max:20',
            'gender' => 'required|string|in:male,female,other,not specified',
        ]);

        $resp = $this->userRepository->create($request->all());

        if ($resp['status'] == 'success') {
            return redirect()->route('admin.user.list.all')->with('success', 'New user created');
        } else {
            return redirect()->back()->with('failure', $resp['message'])->withInput($request->all());
        }

        // return redirect()->route('admin.user.list.all')->with('success', 'New user created');
    }

    public function detail(Request $request, $id)
    {
        $data = $this->userRepository->findById($id);
        return view('admin.user.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = $this->userRepository->findById($id);
        return view('admin.user.edit', compact('data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|integer|digits:10',
            'whatsapp_no' => 'nullable|integer|digits:10',
            'gender' => 'required|string|in:male,female,other,not specified',
        ]);

        $resp = $this->userRepository->update($request->all());

        return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function delete(Request $request, $id)
    {
        $resp = $this->userRepository->delete($request->all());
        return redirect()->back()->with($resp['status'], $resp['message']);
    }

    public function status(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'password' => 'required|string|min:2|max:20',
        ]);

        $resp = $this->userRepository->resetPassword($request->all());

        return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

}
