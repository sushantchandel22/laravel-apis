@extends('layout.main')
@section('content')
<form method="PUT" action="http://127.0.0.1:8000/api/user{id}">
    <div>
        <label>FirstName</label>
        <input type="text" name="firstname">
        <p class="text-danger"></p>
    </div>
    <div>
        <label>LastName</label>
        <input type="text" name="lastname">
        <p class="text-danger"></p>
    </div>
    <div>
        <label>City</label>
        <input type="text" name="city">
        <p class="text-danger"></p>
    </div>
    <div>
        <label>Street</label>
        <input type="text" name="street">
        <p class="text-danger"></p>
    </div>
    <div>
        <label>Phone</label>
        <input type="tel" name="phone">
        <p class="text-danger"></p>
    </div>
    <div>
        <label>Zipcode</label>
        <input type="text" name="zipcode">
        <p class="text-danger"></p>
    </div>
    <button type="submit">Submit</button>
</form>
<script>
    
</script>
@endsection