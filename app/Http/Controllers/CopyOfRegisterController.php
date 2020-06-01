<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PdfUpload;
use App\Room;
use App\CopyOfRegister;
use Illuminate\Support\Facades\Storage;

class CopyOfRegisterController extends Controller
{
    public function upload(PdfUpload $request,$id)
    {
        $request->validated();
        $file = $request->file_name;

        $fileName = time().'.'.$file->getClientOriginalExtension();
        $target_path = storage_path('/app/pdf_uploads/');
        $file->move($target_path,$fileName);

        Room::find($id)->copyOfRegisters()->create([
            'pdf_filename' => $fileName,
        ]);
        $room = new Room();
        $room = $room->getForRoomsShowRoomId($id);
        \Session::flash('flash_message', '登記簿謄本を登録しました');
        return view('rooms.show',compact('room'));
    }

    public function show($id)
    {
        $disk = 'local';
        $storage = Storage::disk($disk);
        $file_name = CopyOfRegister::where('id',$id)->value('pdf_filename');
        $pdf_path = 'pdf_uploads/'.$file_name;
        $file = $storage->get($pdf_path);

        return response($file, 200)
                ->header('Content-Type','application/pdf')
                ->header('Content-Disposition','inline; filename"' .$file_name . '"');
    }
}
