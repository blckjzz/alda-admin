@foreach($items as $menu_item)
    <li class=""><a href="{{ $menu_item->link() }}">
            <i class=""></i>  <span>{{  $menu_item->title  }}</span>
        </a>
    </li>
@endforeach


