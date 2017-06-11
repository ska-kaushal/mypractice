@if(!empty($subtopicList))
    @foreach($subtopicList as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
@endif