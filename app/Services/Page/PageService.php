<?php

namespace App\Services\Page;

use App\Models\Page;

class PageService
{

    public static function getViewContent($view)
    {
        $filePath = resource_path(sprintf('views/pages/%s.blade.php', $view));
        $exists = file_exists($filePath);
        if ($exists) {
            $re = '/@section\(\'content\'\)(.*)@endsection/s';
            preg_match_all($re, file_get_contents($filePath), $matches);
            if ($matches) {
                return $matches[1][0];
            }
        }

        return null;
    }

    public function getViewPath($title)
    {
        return resource_path('views/pages') . '/' . $title . '.blade.php';
    }

    public function saveView(String $html, String $title)
    {
        file_put_contents($this->getViewPath($title), $this->buildHtml($html));
    }

    public function buildHtml($content)
    {
        $filePath = resource_path('views/pages/template.blade.php');
        $file = file_get_contents($filePath);
        $html = str_replace('HTMLCONTENT', $content, $file);
        return $html;
    }

    public function deleteView(String $title)
    {
        $filePath = $this->getViewPath($title);
        $exists = file_exists($filePath);
        if ($exists) {
            unlink($filePath);
        }
    }

    public static function getRoutes()
    {
        $pages = Page::select('title', 'view')->get()->mapWithKeys(function($item, $key) {
            return [url(sprintf('/pages/%s', $item['view'])) => 'Pages['. $item['title'].']'];
        } );

        return $pages->toArray();
    }

}

