@extends('layout.main')
@section('mainsection')
    <form method="POST" action="http://127.0.0.1:8000/api/signup" id="userForm">
        @csrf
        <div>
            <label>Username</label>
            <input type="text" name="username">
            <p class="text-danger"></p>
        </div>
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
            <label>Email</label>
            <input type="email" name="email">
            <p class="text-danger"></p>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
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
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch('http://127.0.0.1:8000/api/signup', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        document.querySelectorAll('.text-danger').forEach(el => el.innerHTML = '');

                        for (let key in data.errors) {
                            let errorMessage = data.errors[key][0];
                            let errorElement = document.querySelector(`[name="${key}"]`).nextElementSibling;
                            errorElement.innerHTML = errorMessage;
                        }
                    } else {
                        console.log('Success:', data);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
