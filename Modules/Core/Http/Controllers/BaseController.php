<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected $title = '';
    protected $subtitle = '';
    protected $breadcrumb = [];

    protected $routeCollection = [];
    protected $modules = [];

    public function __construct()
    {
    }

    protected function view($view, $data = [])
    {
        return view($view, $this->getDataView($data));
    }

    protected function getDataView($data)
    {
        $this->routeCollection = \Route::getRoutes();
        $this->modules = \Module::collections();
        $this->menuEstructure = $this->getMenuEstructure();

        return array_merge([
            'controller'  => $this,
            'user'        => auth()->user(),
            'title'       => $this->getTitle(),
            'subtitle'    => $this->getSubtitle(),
            'breadcrumb'  => $this->getBreadcrumb(),
            'menuBackend' => $this->getMenuBackend(),
        ], $data);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        return $this->title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setSubtitle($subtitle)
    {
        return $this->subtitle;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    public function setBreadcrumb($breadcrumb)
    {
        return $this->breadcrumb;
    }

    public function getMenuEstructure()
    {
        $menu = [];
        foreach ($this->modules as $name => $module) {
            $estructures = config(strtolower($name) . '.menu', []);
            if (empty($estructures)) {
                continue;
            }

            foreach ($estructures as $estructure) {
                $menu[] = $estructure;
            }
        }

        return collect($menu)->sortBy('order');
    }

    public function getMenuBackend($iteration = 0, $estructures = [])
    {
        if ($iteration === 0) {
            $estructures = $this->menuEstructure;
        }

        $html = '';
        foreach ($estructures as $estructure) {
            if (isset($estructure['children'])) {
                $html .=
                    '<li class="treeview">' .
                        '<a href="#">' .
                            '<i class="fa ' . $estructure['icon'] . '"></i> ' .
                            '<span>' . $estructure['text'] . '</span>' .
                            '<span class="pull-right-container">' .
                                '<i class="fa fa-angle-left pull-right"></i>' .
                            '</span>' .
                        '</a>' .
                        '<ul class="treeview-menu">' .
                            $this->getMenuBackend($iteration + 1, $estructure['children']) .
                        '</ul>' .
                    '</li>';
            } else {
                $url = $this->getRouteByName($estructure['route']);
                $html .=
                    '<li' . (request()->is($url) ? ' class="active"' : '') . '>' .
                        '<a href="' . $url . '">' .
                            '<i class="fa ' . $estructure['icon'] . '"></i>' .
                            '<span>' . $estructure['text'] . '</span>' .
                        '</a>' .
                    '</li>';
            }
        }

        return $html;
    }

    public function getRouteByName($name)
    {
        return $this->routeCollection->getByName($name) ? route($name) : '#';
    }
}
