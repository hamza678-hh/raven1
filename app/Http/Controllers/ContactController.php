<?php


namespace App\Http\Controllers;
use App\Http\Requests\StorContactRequest;

use App\Models\Contact;
use Illuminate\Http\Requests;

class ContactController extends Controller
{
     public function store(StorContactRequest $request) {

      
      $data= $request->validated();
  
       Contact::create($data);
       return back()->with('status-message','Your message send successfully');
       
    }
}
