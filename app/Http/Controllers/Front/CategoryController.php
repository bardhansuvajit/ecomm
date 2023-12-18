<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\CategoryInterface;

class CategoryController extends Controller
{
    private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $resp = $this->categoryRepository->listAllActiveCat1();

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            return view('front.category.index', compact('data'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function detail1(Request $request, $slug)
    {
        $resp = $this->categoryRepository->detailBySlug($slug, 1);

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            $subs = $resp['subs'];
            // $type = 1;

            // return view('front.category.detail', compact('data', 'subs', 'type'));
            return view('front.category.detail', compact('data', 'subs'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function detail2(Request $request, $parent, $slug)
    {
        $resp = $this->categoryRepository->detailBySlug($slug, 2);

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            $subs = $resp['subs'];
            // $type = 2;

            // return view('front.category.detail', compact('data', 'subs', 'type'));
            return view('front.category.detail', compact('data', 'subs'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

}
