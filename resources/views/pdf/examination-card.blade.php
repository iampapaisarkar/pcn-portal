<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Examination Card (Batch: {{$data->batch->batch_no}}-{{$data->batch->year}}) - {{env('APP_NAME')}} </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
        <style type="text/css">
        body{
                font-family: Arial;
        }
        @page { size: 245pt 370pt; }
        .cls_003{font-family:Arial,serif;font-size:14.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_003{font-family:Arial,serif;font-size:14.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_004{font-family:Arial,serif;font-size:24.3px;color:rgb(219,35,31);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_004{font-family:Arial,serif;font-size:24.3px;color:rgb(219,35,31);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_005{font-family:Arial,serif;font-size:14.2px;color:rgb(219,35,31);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_005{font-family:Arial,serif;font-size:14.2px;color:rgb(219,35,31);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_002{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_002{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_006{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_006{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_007{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_007{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_008{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_008{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_009{font-family:Arial,serif;font-size:16.1px;color:rgb(255,254,255);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_009{font-family:Arial,serif;font-size:16.1px;color:rgb(255,254,255);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        </style>
    <body>
            
        <div style="position:absolute;left:50%;margin-left:-148px;top:0px;width:297px;height:419px;border-style:outset;overflow:hidden">
        <div style="position:absolute;left:0px;top:0px">
        <img src="{{$background}}"width=297 height=419>
        </div>
        <div style="position:absolute;left:80px;top:21px"><img src="{{$photo}}" alt="" style="width: 135px; height: 135px; border-radius: 20px;"></div>
        <div style="position:absolute;left:100.10px;top:158.55px" class="cls_003"><span class="cls_003">{{$data->user->firstname}} {{$data->user->lastname}}</span></div>
        <div style="position:absolute;left:110.39px;top:180.98px" class="cls_004"><span class="cls_004">{{strtoupper($data->tier->name)}}</span>
        </div>
        <div style="position:absolute;left:27.80px;top:210.81px" class="cls_005"><span class="cls_005">{{$data->indexNumber->arbitrary_1 .'/'. $data->indexNumber->arbitrary_2 .'/'. $data->indexNumber->batch_year .'/'. $data->indexNumber->state_code .'/'. $data->indexNumber->school_code .'/'. $data->indexNumber->tier .'/'. $data->indexNumber->id}}</span></div>
        <div style="position:absolute;left:70.48px;top:227.76px" class="cls_002"><span class="cls_002">Batch: {{$data->batch->batch_no}}-{{$data->batch->year}}</span></div>
        <div style="position:absolute;left:86.93px;top:260.05px" class="cls_006"><span class="cls_006">Training Centre:</span></div>
        <div style="position:absolute;left:107.41px;top:290.85px" class="cls_007"><span class="cls_007">{{$data->school->name}}</span></div>
        <div style="position:absolute;left:104.27px;top:315.72px" class="cls_008"><span class="cls_008">{{$data->user_state->name}}</span>
        </div>
        <div style="position:absolute;left:6.47px;top:392.52px" class="cls_009"><span class="cls_009">MEPTP Examination Card</span></div>
        </div>
    </body>
</html>
