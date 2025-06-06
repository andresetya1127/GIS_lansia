<div class="d-flex mb-4 justify-content-end align-items-center">
  <form action="{{ $url ?? '' }}" method="POST" enctype="multipart/form-data">
    @csrf
      <label for="{{ $id ?? '' }}" class="btn btn-primary">
        <i class="{{ $icon ?? 'd-none' }}"></i> {{ $title ?? '' }}
        <input type="file" name="{{ $id ?? '' }}" id="{{ $id ?? '' }}" class="d-none" accept="{{ $accept ?? '' }}">
    </label>
  </form>
  <a href="{{ route('lansia.export')}}" class="btn btn-secondary ms-2">
    <i class="fa-solid fa-file-export"></i> Export
  </a>
</div>

<script>
    $(document).ready(function() {
        $('input[type="file"]').on('change', function() {
            if (this.files && this.files[0]) {
                $(this).closest('form').submit();
            }
        });
    });
</script>
