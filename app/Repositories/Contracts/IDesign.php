<?php


namespace App\Repositories\Contracts;


use Illuminate\Http\Request;

interface IDesign
{
    public function applyTags($id, array $data);

    public function addComment($designId, array $data);

    public function like($id);

    public function totalLikes($id);

    public function isLikedByUser($designId);

    public function search(Request $request);

}
