@if(isset($container) && $container === true)
    @if(array_get($options, 'container_tag'))
        <{{ array_get($options, 'container_tag') }} class="{{ array_get($options, 'container_class') }}" id="{{ array_get($options, 'container_id') }}">
    @endif
@endif
@if(isset($menuNodes) && $menuNodes->count())
    <ul role="menu" id="{{ array_get($options, 'id') }}" class="{{ $isChild === true ? array_get($options, 'submenu_class') : array_get($options, 'class') }}">
        @foreach($menuNodes as $node)
            @php
                $childActivatedNodes = parent_active_menu_item_ids(
                    $node,
                    array_get($options, 'menu_active.type'),
                    array_get($options, 'menu_active.entity_id')
                );
                $isMenuItemActive = is_menu_item_active(
                    $node,
                    array_get($options, 'menu_active.type'),
                    array_get($options, 'menu_active.entity_id')
                );
                $isHasChildren = $node->children && $node->children->count() > 0;
                $isCurrentParent = in_array((int)$node->id, $childActivatedNodes);
            @endphp
            <li class="{{ 'menu-item ' . array_get($options, 'item_class') }} {{ $isCurrentParent ? ' current-parent-menu-item ' : '' }} {{ $isMenuItemActive ? ' active ' : '' }} {{ $isHasChildren ? ' menu-item-has-children ' . array_get($options, 'has_sub_class') : '' }}">
                <a href="{{ $node->url }}" @if($node->target) target="{{ $node->target }}" @endif title="{{ $node->title }}">
                    @if($node->icon_font)
                        <i class="{{ $node->icon_font }}"></i>
                    @endif
                    {{ $node->title }}
                </a>
                @include('webed-menus::front._renderer.menu', [
                    'menuNodes' => $node->children,
                    'options' => $options,
                    'isChild' => true,
                    'container' => false,
                ])
            </li>
        @endforeach
    </ul>
@endif
@if(isset($container) && $container === true)
    @if(array_get($options, 'container_tag'))
        </{{ array_get($options, 'container_tag') }}>
    @endif
@endif
