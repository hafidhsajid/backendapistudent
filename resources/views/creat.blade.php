<div class="container">
    <form method="post" action="{{ route('students.store') }}"
          enctype="multipart/form-data">
      {{-- @csrf --}}
      <img src="{{ url('/image/ava.png') }}" alt="">
      <div class="image">
        <label><h4>Add image</h4></label>
        <input type="file" class="form-control" required name="image">
      </div>

      <div class="post_button">
        <button type="submit" class="btn btn-success">Add</button>
      </div>
    </form>
  </div>
