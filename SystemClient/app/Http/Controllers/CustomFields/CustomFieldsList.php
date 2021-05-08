<?php


namespace App\Http\Controllers\CustomFields;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HttpResponse;
use App\Models\Custom;
use Illuminate\Http\Request;

class CustomFieldsList extends Controller
{

    public function index()
    {
        $customs = Custom::all();
        return view('CustomFields.customFields', compact('customs'));

    }

    public function addCustom(Request $request)
    {
        if(!$request->get('name'))
        {
            $message = "Pole 'Nazwa' jest wymagane.";
            $response = HttpResponse::error($message);
            return back()->with(['message' => $response]);
        }

        $custom = Custom::where('name', $request->get('name'))->first();

        if($custom)
        {
            $message = "Custom Field o takiej nazwie już istnieje.";
            $response = HttpResponse::error($message);
            return back()->with(['message' => $response]);
        }

        try
        {
            Custom::create([
                'name' => $request->get('name')
            ]);

            $message = 'Custom Field został dodany!';
            $response = HttpResponse::success($message);
            return back()->with(['message' => $response]);
        }
        catch(\Exception $ex)
        {
            $message = 'Something went wrong! Try again!';
            $response = HttpResponse::error($message);
            return back()->with(['message' => $response]);
        }
    }

    public function editCustom(Request $request)
    {
        if(!$request->get('name'))
        {
            $message = "Pole 'Nazwa' jest wymagane.";
            $response = HttpResponse::error($message);
            return back()->with(['message' => $response]);
        }

        $custom = Custom::where('name', $request->get('name'))->first();

        if($custom && $custom->name != $request->get('name'))
        {
            $message = "Custom Field o takiej nazwie już istnieje.";
            $response = HttpResponse::error($message);
            return back()->with(['message' => $response]);
        }
        try
        {
            Custom::where('id', $request->get('id'))->update([
                'name' => $request->get('name')
            ]);

            $message = 'Custom Field został edytowany!';
            $response = HttpResponse::success($message);
            return back()->with(['message' => $response]);
        }
        catch(\Exception $ex)
        {
            $message = 'Something went wrong! Try again!';
            $response = HttpResponse::error($message);
            return back()->with(['message' => $response]);
        }

    }

}
