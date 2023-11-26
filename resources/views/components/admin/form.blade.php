@props(['post'=>null])
<x-errors />
<form {{ $attributes  }}>
   {{ $slot }}
    @csrf
</form>
