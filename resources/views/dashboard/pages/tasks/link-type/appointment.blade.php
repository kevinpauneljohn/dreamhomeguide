@foreach($options as $option)
    <option value="{{$option->id}}">{{$option->title}} - (Client: {{$option->agent->full_name}})</option>
@endforeach
