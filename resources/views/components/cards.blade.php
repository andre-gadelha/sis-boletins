<div class="card" style="width: 18rem;text-align: center" >
    <i class="@isset($icon) {{ $icon }}@endisset" style="font-size:80px; text-align: center"></i>
    <div class="card-body">
      <h5 class="card-title">
            @isset($title)
                {{ $title }}                
            @endisset
      </h5>
      <p class="card-text">
            @isset($description)
                {{ $description }}                
            @endisset
      </p>
      <p>
        <a href="@isset($route) {{ $route }}@endisset" class="btn btn-primary">Acesse</a>
      </p>
    </div>
  </div>