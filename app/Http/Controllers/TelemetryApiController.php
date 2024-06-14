<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelemetryApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'mac' => 'required|mac_address',
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'ERROR!', 'error' => $validator->errors()->all()[0]]);
        }

        $device = Device::createOrFirst([
            'mac_address' => $request->mac
        ], [
            'name' => fake('id')->safeColorName,
        ]);

        $device->telemetries()->create([
            'device_id' => $device->id,
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return response()->json(['status' => 'OK!']);
    }
}
