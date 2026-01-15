@if(is_null($model_selected))
    @foreach($modelUnits as $unit)
        <option value="{{$unit->id}}">{{$unit->name}}</option>
    @endforeach
@else
    @foreach($modelUnits as $unit)
        <option value="{{$unit->id}}" @if($model_selected == $unit->id)selected @endif>{{$unit->name}}</option>
    @endforeach
@endif

