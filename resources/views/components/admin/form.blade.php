@props(['post'=>null])
<form {{ $attributes  }}>
   {{ $slot }}
    @csrf
</form>
