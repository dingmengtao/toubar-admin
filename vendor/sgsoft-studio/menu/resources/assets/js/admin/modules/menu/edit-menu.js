// Init
let WebEdManageMenu = function () {
    "use strict";

    let $body = $('body');

    let $_TARGET = $('.nestable-menu');

    let $_UPDATE_TO = $('#menu_structure');

    let $_DELETED_NODES = $('#deleted_nodes');

    let DELETED_NODES = [];

    let handleItems = function () {
        /**
         * The templates
         */
        let MENU_NESTABLE_TEMPLATES = {
            listGroup: $('#menus_template_list_group').html(),
            listItem: $('#menus_template_list_item').html(),
        };

        let MENU_DATA = Helpers.jsonDecode($_UPDATE_TO.val(), []);

        let initNestable = function () {
            /**
             * Init nestable
             */
            $_TARGET.nestable({
                group: 1,
                maxDepth: 10,
                expandBtnHTML: '',
                collapseBtnHTML: ''
            });
        };

        let handleDetails = function () {
            /**
             * Toggle item details
             */
            $body.on('click', '.dd-item .dd3-content a.show-item-details', function (event) {
                event.preventDefault();
                $(this).toggleClass('active');
                $(this).closest('.dd-item').toggleClass('active');
            });

            /**
             * Change details value
             */
            $body.on('change keyup', '.dd-item .item-details .fields input[type=text], .dd-item .item-details .fields select', function (event) {
                event.preventDefault();
                let $current = $(this);
                let $label = $current.closest('label'),
                    $currentItem = $current.closest('.dd-item');
                $currentItem.data($label.attr('data-field'), $current.val());
            });
        };

        let renderListGroup = function (data) {
            let $listGroup = $(MENU_NESTABLE_TEMPLATES.listGroup);
            _.each(data, function (value, index) {
                $listGroup.append(renderListItem(value));
            });

            return $listGroup;
        };

        let renderListItem = function (data) {
            let listItem = MENU_NESTABLE_TEMPLATES.listItem;
            let itemType = Helpers.arrayGet(data, 'type', '');

            let title = Helpers.arrayGet(data, 'title');
            if (!_.size(title)) {
                title = Helpers.arrayGet(data, 'model_title', '');
            }

            listItem = listItem.replace(/__title__/gi, title);
            listItem = listItem.replace(/__type__/gi, itemType);
            let $listItem = $(listItem);

            $listItem.find('[data-field=title] input[type=text]').val(Helpers.arrayGet(data, 'title', ''));
            $listItem.find('[data-field=icon_font] input[type=text]').val(Helpers.arrayGet(data, 'icon_font', ''));
            $listItem.find('[data-field=css_class] input[type=text]').val(Helpers.arrayGet(data, 'css_class', ''));
            $listItem.find('[data-field=target] select').val(Helpers.arrayGet(data, 'target', ''));

            if (itemType !== 'custom-link') {
                $listItem.find('[data-field=url]').remove();
                $listItem.data('url', null);
            } else {
                $listItem.find('[data-field=url] input[type=text]').val(Helpers.arrayGet(data, 'url', ''));
                $listItem.data('url', Helpers.arrayGet(data, 'url', null));
            }

            $listItem.data('id', Helpers.arrayGet(data, 'id', ''));
            $listItem.data('entity_id', Helpers.arrayGet(data, 'entity_id', ''));
            $listItem.data('type', Helpers.arrayGet(data, 'type', ''));
            $listItem.data('title', Helpers.arrayGet(data, 'title', ''));
            $listItem.data('model_title', Helpers.arrayGet(data, 'model_title', ''));
            $listItem.data('icon_font', Helpers.arrayGet(data, 'icon_font', ''));
            $listItem.data('css_class', Helpers.arrayGet(data, 'css_class', ''));
            $listItem.data('target', Helpers.arrayGet(data, 'target', ''));

            if (Helpers.arrayGet(data, 'children', [])) {
                $listItem.append(renderListGroup(Helpers.arrayGet(data, 'children')));
            }
            return $listItem;
        };

        let renderMenu = function () {
            $_TARGET.append(renderListGroup(MENU_DATA));
        };

        let handleAddNew = function () {
            /**
             * Determine when the list group exists
             * If not exists, create new
             */
            if (!_.size($_TARGET.find('> .dd-list'))) {
                $_TARGET.append($(MENU_NESTABLE_TEMPLATES.listGroup));
            }

            /**
             * Handle click button add item
             */
            $body.on('click', '.box-link-menus .add-item', function (event) {
                event.preventDefault();
                let $box = $(this).closest('.box-link-menus');

                switch ($box.data('type')) {
                    case 'custom-link':
                        $_TARGET.find('> .dd-list').append(addCustomLink($box));
                        break;
                    default:
                        $_TARGET.find('> .dd-list').append(addOtherLinks($box));
                        break;
                }
            });

            let addCustomLink = function ($_box) {
                let data = {
                    id: null,
                    entity_id: null,
                    type: $_box.data('type'),
                    title: $_box.find('input[type=text][data-field=title]').val(),
                    model_title: null,
                    url: $_box.find('input[type=text][data-field=url]').val(),
                    css_class: $_box.find('input[type=text][data-field=css_class]').val(),
                    icon_font: $_box.find('input[type=text][data-field=icon_font]').val(),
                    target: $_box.find('select[data-field=target]').val(),
                };

                if (!data.title || !data.url) {
                    return;
                }

                $_box.find('input[type=text]').val('');

                return renderListItem(data);
            };

            let addOtherLinks = function ($_box) {
                let globalData = {
                    id: null,
                    type: $_box.data('type'),
                };
                let data = [];
                $_box.find('input[type=checkbox]:checked').each(function () {
                    let $current = $(this);
                    let $label = $current.closest('label');
                    let currentData = $.extend(true, {
                        entity_id: $current.val(),
                        title: null,
                        model_title: $label.text().trim(),
                        url: '',
                        css_class: '',
                        icon_font: '',
                    }, globalData);
                    data.push(renderListItem(currentData));
                });

                $_box.find('input[type=checkbox]').prop('checked', false);

                return data;
            }
        };

        let handleRemove = function () {
            /**
             * Remove node
             */
            $body.on('click', '.dd-item .item-details .btn-remove', function (event) {
                event.preventDefault();
                let $parent = $(this).closest('.dd-item');
                let $childs = $parent.find('> .dd-list > .dd-item');
                if (_.size($childs)) {
                    $parent.after($childs);
                }
                DELETED_NODES.push($parent.data('id'));
                $parent.remove();
            });
        };

        /**
         * Render
         */
        renderMenu();
        initNestable();
        handleDetails();
        handleAddNew();
        handleRemove();
    };

    let exportData = function () {
        /**
         * Serialize data from nestable
         */
        let serializeData = function () {
            return $_TARGET.nestable('serialize');
        };

        /**
         * Submit the form
         */
        $body.on('submit', $_TARGET.closest('form'), function (event) {
            //event.preventDefault();
            $_UPDATE_TO.val(Helpers.jsonEncode(serializeData()));
            $_DELETED_NODES.val(Helpers.jsonEncode(DELETED_NODES));
        });
    };

    return {
        /**
         * Init the module
         */
        init: function () {
            handleItems();
            exportData();
        }
    };
}();

(function ($) {
    $(window).load(function () {
        WebEdManageMenu.init();
    });
})(jQuery);
