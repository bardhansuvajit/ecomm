<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\UserInterface;

use App\Models\ProductReview;
use App\Models\Product;

class ReviewController extends Controller
{
    private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = ProductReview::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('email', 'like', '%'.$keyword.'%')
            ->orWhere('phone_number', 'like', '%'.$keyword.'%')
            ->orWhere('review', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->latest('id')->paginate(25);

        return view('admin.review.index', compact('data'));
    }

    public function create(Request $request)
    {
        $products = Product::orderBy('title')->get();
        $users = $this->userRepository->listActive('first_name', 'asc');

        return view('admin.review.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'user_id' => 'required|integer',
            'guest_review' => 'required|integer|in:0,1',
            'name' => 'required|string|min:1|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|integer|digits:10',
            'rating' => 'required|integer|between:1,5',
            'heading' => 'required|string|min:2|max:1000',
            'review' => 'required|string|min:5',
        ]);

        $product_review = new ProductReview();
        $product_review->product_id = $request->product_id;
        $product_review->guest_review = $request->guest_review;
        $product_review->user_id = ($request->guest_review == 1) ? 0 : $request->user_id;
        $product_review->name = $request->name;
        $product_review->email = $request->email ?? null;
        $product_review->phone_number = $request->phone_number ?? null;
        $product_review->rating = $request->rating;
        $product_review->heading = $request->heading;
        $product_review->review = $request->review;
        $product_review->save();

        return redirect()->route('admin.review.list.all')->with('success', 'New review created');
    }

    public function detail(Request $request, $id)
    {
        $data = ProductReview::findOrFail($id);
        return view('admin.review.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $data = ProductReview::findOrFail($id);
        $products = Product::orderBy('title')->get();
        return view('admin.review.edit', compact('data', 'products'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'review_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'user_id' => 'required|integer',
            'guest_review' => 'required|integer|in:0,1',
            'name' => 'required|string|min:1|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|integer|digits:10',
            'rating' => 'required|integer|between:1,5',
            'heading' => 'required|string|min:2|max:1000',
            'review' => 'required|string|min:5|max:1000',
        ]);

        $product_review = ProductReview::findOrFail($request->review_id);
        $product_review->product_id = $request->product_id;
        $product_review->guest_review = $request->guest_review;
        $product_review->user_id = ($request->guest_review == 1) ? 0 : $request->user_id;
        $product_review->name = $request->name;
        $product_review->email = $request->email ?? null;
        $product_review->phone_number = $request->phone_number ?? null;
        $product_review->rating = $request->rating;
        $product_review->heading = $request->heading;
        $product_review->review = $request->review;
        $product_review->save();

        return redirect()->route('admin.review.list.all')->with('success', 'Review updated');
    }

    public function delete(Request $request, $id)
    {
        $data = ProductReview::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Review deleted');
    }

    public function status(Request $request, $id)
    {
        $data = ProductReview::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function position(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductReview::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }
}
