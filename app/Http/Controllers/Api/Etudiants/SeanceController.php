<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Seance;
use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SeanceController extends BaseController
{
    public function create(Request $request)
    {
        if (Auth::user()->can('create', Seance::class)) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'jour' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'class_id' => 'required',
                'salle_id' => 'required',
                'module_id' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->SendError('validatorError', $validator->errors());
            }
            $seance = Seance::create($input);
            $action                         = new Action();
            $action->user_id                = Auth::user()->id;
            $action->status                 = 1;
            $action->type                   = 'seance-added';
            $action->content                = json_encode($request->all());
            $action->processed_by       = Auth::user()->id;
            $action->processed_on   = date('Y-m-d H:i:s', time());
            $action->save();
            return $this->SendResponse($seance, 'seance added successfuly');
        } else {
            $action = new Action();
            $action->user_id        = Auth::user()->id;
            $action->status         = 0;
            $action->type           = 'seance-added';
            $action->content        = json_encode($request->all());
            $action->save();
        }
    }
}
