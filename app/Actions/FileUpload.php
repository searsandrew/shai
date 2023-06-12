<?php

namespace App\Actions;

use App\Models\File;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class FileUpload
{
    use AsAction;

    public function handle(ActionRequest $request)
    {
        $fileModel = new File;

        if($request->file())
        {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();

            return [
                'status' => 'success',
                'file' => $fileName
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Not a File'
        ];
    }

    public function asController(ActionRequest $request)
    {
        $request->validated();
        $results = $this->handle($request);
        return back()->with('results', $results);
    }

    public static function routes(Router $router)
    {
        $router->post('upload-csv', static::class)->name('csv.upload');
    }

    public function rules() : array
    {
        return [
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ];
    }
}