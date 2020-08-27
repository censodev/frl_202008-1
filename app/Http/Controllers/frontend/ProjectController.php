<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ProjectController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.project.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
		$data->title   = 'Projects';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $data = new Collection();
		$data->title   = 'Project Detail';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'detail';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

}
