<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanelController extends Controller
{
    public function index()
    {
        /*return Role::where('label', 'manager')->first()->permissions()->sync([1,2]);
        return auth()->user()->roles()->get();*/
        $month = 12;
        $paymentSuccess = Payment::spanningPayment($month , true)->get();
        $paymentUnSuccess = Payment::spanningPayment($month , false)->get();
        $labels = $this->getLastMonths($month);

        $values['success'] = $this->CheckCount($paymentSuccess , $month);
        $values['unsuccess'] = $this->CheckCount($paymentUnSuccess , $month);

        return view('Admin.panel' , compact('labels' , 'values'));
    }
     public function uploadImageSubject()
     {
         $this->validate(request(), [
             'upload' => 'required|mimes:jpeg,png,bmp'
         ]);
         $year = Carbon::now()->year;
         $imagePath = "/upload/images/{$year}/";
         $file = request()->file('upload');
         $fileName = $file->getClientOriginalName();
         if(file_exists(public_path($imagePath).$fileName)){
             $fileName = Carbon::now()->timestamp . $fileName;
         }
         $file->move(public_path($imagePath), $fileName);
         $url = $imagePath . $fileName;

         $response = [
             "uploaded" => 1,
             "filename" => $fileName,
             "url" => $url,
             "error" => ''
         ];
         return $response;
      //   return "<script>window.parent.CKEDITOR.tools.callFunction(1,'($url)','')</script>";
     }
    private function getLastMonths($month)
    {
        for ($i = 0 ; $i < $month ; $i++) {
            $labels[] = jdate( Carbon::now()->subMonths($i))->format('%B');
        }
        return array_reverse($labels);
    }
    private function CheckCount($count, $month)
    {
        $new = [];
        for ($i = 0 ; $i < $month ; $i++) {
            $new[$i] = empty($count[$i]) ? 0 : $count[$i];
        }
        return array_reverse($new);
    }
}
