<?php

namespace App\Services;

class CreateUpdateArticleService
{
    public function execute($request)
    {
        return $this->checkThumbnail($request);
    }

    private function checkThumbnail(object $request)
    {
        $resources = array();
        $thumbnail_resource = '';

        for ($i = 0; $i < count($request->file('upload_image')); $i++) {
            $resource = uniqid();
            $resources[] = $resource;
            if ($request->has('is-thumbnail') && $request->get('is-thumbnail') == $request->file('upload_image')[$i]->getClientOriginalName()) {
                $thumbnail_resource = $resource;
                $index = array_search($thumbnail_resource, $resources);
                array_splice($resources, $index, 1);
            }
            // upload先指定
            $uploaded_path = 'img/' . $resource . '.png';
            // fileの移動
            move_uploaded_file($request->file('upload_image')[$i], $uploaded_path);
        }
        if (empty($thumbnail_resource)) {
            $thumbnail_resource = current($resources);
            $index = array_search($thumbnail_resource, $resources);
            array_splice($resources, $index, 1);
        }
        return [$resources, $thumbnail_resource];
    }
}