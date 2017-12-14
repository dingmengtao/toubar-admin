import {WebEd} from "../../../../../../../base/resources/assets/js/Helpers/WebEd";

class UseCustomFields {
    constructor() {
        this.$body = $('body');

        /**
         * Where to show the custom field elements
         */
        this.$_UPDATE_TO = $('#custom_fields_container');
        /**
         * Where to export json data when submit form
         */
        this.$_EXPORT_TO = $('#custom_fields_json');

        this.CURRENT_DATA = Helpers.jsonDecode(this.$_EXPORT_TO.val(), []);

        if (this.CURRENT_DATA) {
            this.handleCustomFields();
            this.exportData();
        }
    }

    handleCustomFields() {
        let _self = this;

        let repeaterFieldAdded = 0;
        /**
         * The html template of custom fields
         */
        let FIELD_TEMPLATE = {
            fieldGroup: $('#_render_customfield_field_group_template').html(),
            globalSkeleton: $('#_render_customfield_global_skeleton_template').html(),
            text: $('#_render_customfield_text_template').html(),
            number: $('#_render_customfield_number_template').html(),
            email: $('#_render_customfield_email_template').html(),
            password: $('#_render_customfield_password_template').html(),
            textarea: $('#_render_customfield_textarea_template').html(),
            checkbox: $('#_render_customfield_checkbox_template').html(),
            radio: $('#_render_customfield_radio_template').html(),
            select: $('#_render_customfield_select_template').html(),
            image: $('#_render_customfield_image_template').html(),
            file: $('#_render_customfield_file_template').html(),
            wysiwyg: $('#_render_customfield_wysiswg_template').html(),
            repeater: $('#_render_customfield_repeater_template').html(),
            repeaterItem: $('#_render_customfield_repeater_item_template').html(),
            repeaterFieldLine: $('#_render_customfield_repeater_line_template').html()
        };

        let initWYSIWYG = function ($element, type) {
            WebEd.wysiwyg($element, {
                toolbar: type
            });
            return $element;
        };

        let initCustomFieldsBoxes = function (boxes, $appendTo) {
            boxes.forEach(function (box, indexBox) {
                let skeleton = FIELD_TEMPLATE.globalSkeleton;
                skeleton = skeleton.replace(/__type__/gi, box.type || '');
                skeleton = skeleton.replace(/__title__/gi, box.title || '');
                skeleton = skeleton.replace(/__instructions__/gi, box.instructions || '');

                let $skeleton = $(skeleton);
                let $data = registerLine(box);

                $skeleton.find('.meta-box-wrap').append($data);

                $skeleton.data('lcf-registered-data', box);

                $appendTo.append($skeleton);

                if (box.type === 'wysiwyg') {
                    initWYSIWYG($skeleton.find('.meta-box-wrap .wysiwyg-editor'), box.options.wysiwygToolbar || 'basic');
                }
            });
        };

        let registerLine = function (box) {
            let result = FIELD_TEMPLATE[box.type],
                $wrapper = $('<div class="lcf-' + box.type + '-wrapper"></div>');
            $wrapper.data('lcf-registered-data', box);
            switch (box.type) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                    result = result.replace(/__placeholderText__/gi, box.options.placeholderText || '');
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    break;
                case 'textarea':
                    result = result.replace(/__rows__/gi, box.options.rows || 3);
                    result = result.replace(/__placeholderText__/gi, box.options.placeholderText || '');
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    break;
                case 'image':
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    if (!box.value) {
                        let defaultImage = $(result).find('img').attr('data-default');
                        result = result.replace(/__image__/gi, defaultImage || box.options.defaultValue || '');
                    } else {
                        result = result.replace(/__image__/gi, box.value || box.options.defaultValue || '');
                    }
                    break;
                case 'file':
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    break;
                case 'select': {
                    let $result = $(result);
                    let choices = parseChoices(box.options.selectChoices);
                    choices.forEach(function (choice, index) {
                        $result.append('<option value="' + choice[0] + '">' + choice[1] + '</option>');
                    });
                    $result.val(Helpers.arrayGet(box, 'value', box.options.defaultValue));
                    $wrapper.append($result);
                    return $wrapper;
                }
                    break;
                case 'checkbox': {
                    let choices = parseChoices(box.options.selectChoices);
                    let boxValue = Helpers.jsonDecode(box.value);
                    choices.forEach(function (choice, index) {
                        let template = result.replace(/__value__/gi, choice[0] || '');
                        template = template.replace(/__title__/gi, choice[1] || '');
                        template = template.replace(/__checked__/gi, ($.inArray(choice[0], boxValue) != -1) ? 'checked' : '');
                        $wrapper.append($(template));
                    });
                    return $wrapper;
                }
                    break;
                case 'radio': {
                    let choices = parseChoices(box.options.selectChoices);
                    let isChecked = false;
                    choices.forEach(function (choice, index) {
                        let template = result.replace(/__value__/gi, choice[0] || '');
                        template = template.replace(/__id__/gi, box.id + box.slug + repeaterFieldAdded);
                        template = template.replace(/__title__/gi, choice[1] || '');
                        template = template.replace(/__checked__/gi, (box.value === choice[0]) ? 'checked' : '');
                        $wrapper.append($(template));

                        if (box.value === choice[0]) {
                            isChecked = true;
                        }
                    });
                    if (isChecked === false) {
                        $wrapper.find('input[type=radio]:first').prop('checked', true);
                    }
                    return $wrapper;
                }
                    break;
                case 'repeater': {
                    let $result = $(result);
                    $result.data('lcf-registered-data', box);

                    $result.find('> .repeater-add-new-field').html(box.options.buttonLabel || 'Add new item');
                    $result.find('> .sortable-wrapper').sortable();
                    registerRepeaterItem(box.items, box.value || [], $result.find('> .field-group-items'));
                    return $result;
                }
                    break;
                case 'wysiwyg': {
                    result = result.replace(/__value__/gi, box.value || '');

                    let $result = $(result);

                    $result.attr('data-toolbar', box.options.wysiwygToolbar || 'basic');
                }
                    break;
            }
            $wrapper.append($(result));
            return $wrapper;
        };

        let registerRepeaterItem = function (items, data, $appendTo) {
            $appendTo.data('lcf-registered-data', items);
            data.forEach(function (dataItem, indexData) {
                let indexCss = $appendTo.find('> .ui-sortable-handle').length + 1;
                let result = FIELD_TEMPLATE.repeaterItem;
                result = result.replace(/__position__/gi, indexCss);

                let $result = $(result);
                $result.data('lcf-registered-data', items);

                registerRepeaterFieldLine(items, dataItem, $result.find('> .field-line-wrapper > .field-group'));

                $appendTo.append($result);
            });
            return $appendTo;
        };

        let registerRepeaterFieldLine = function (items, data, $appendTo) {
            data.forEach(function (item, index) {
                repeaterFieldAdded++;

                let result = FIELD_TEMPLATE.repeaterFieldLine;
                result = result.replace(/__title__/gi, item.title || '');
                result = result.replace(/__instructions__/gi, item.instructions || '');

                let $result = $(result);
                let $data = registerLine(item);
                $result.data('lcf-registered-data', item);
                $result.find('> .repeater-item-input').append($data);

                $appendTo.append($result);

                if (item.type === 'wysiwyg') {
                    initWYSIWYG($result.find('> .repeater-item-input .wysiwyg-editor'), item.options.wysiwygToolbar || 'basic');
                }
            });
            return $appendTo;
        };

        let parseChoices = function (choiceString) {
            let choices = [];
            choiceString.split('\n').forEach(function (item, index) {
                let currentChoice = item.split(':');
                if (currentChoice[0] && currentChoice[1]) {
                    currentChoice[0] = currentChoice[0].trim();
                    currentChoice[1] = currentChoice[1].trim();
                }
                choices.push(currentChoice);
            });
            return choices;
        };

        /**
         * Remove field item
         */
        this.$body.on('click', '.remove-field-line', function (event) {
            event.preventDefault();
            let current = $(this);
            current.parent().animate({
                    opacity: 0.1
                },
                300, function () {
                    current.parent().remove();
                });
        });

        /**
         * Collapse field item
         */
        this.$body.on('click', '.collapse-field-line', function (event) {
            event.preventDefault();
            let current = $(this);
            current.toggleClass('collapsed-line');
        });

        /**
         * Add new repeater line
         */
        this.$body.on('click', '.repeater-add-new-field', function (event) {
            event.preventDefault();
            let $groupWrapper = $.extend(true, {}, $(this).prev('.field-group-items'));
            let registeredData = $groupWrapper.data('lcf-registered-data');

            repeaterFieldAdded++;

            registerRepeaterItem(registeredData, [registeredData], $groupWrapper);
        });

        /**
         * Init data when page loaded
         */
        this.CURRENT_DATA.forEach(function (group, indexGroup) {
            let groupTemplate = FIELD_TEMPLATE.fieldGroup;
            groupTemplate = groupTemplate.replace(/__title__/gi, group.title || '');

            let $groupTemplate = $(groupTemplate);

            initCustomFieldsBoxes(group.items, $groupTemplate.find('.meta-boxes-body'));

            $groupTemplate.data('lcf-field-group', group);

            _self.$_UPDATE_TO.append($groupTemplate);
        });
    }

    exportData() {
        let _self = this;

        let getFieldGroups = function () {
            let fieldGroups = [];

            $('#custom_fields_container').find('> .meta-boxes').each(function () {
                let $current = $(this);
                let currentData = $current.data('lcf-field-group');
                let $items = $current.find('> .meta-boxes-body > .meta-box');
                currentData.items = getFieldItems($items);
                fieldGroups.push(currentData);
            });
            return fieldGroups;
        };

        let getFieldItems = function ($items) {
            let items = [];
            $items.each(function () {
                items.push(getFieldItemValue($(this)));
            });
            return items;
        };

        let getFieldItemValue = function ($item) {
            let customFieldData = $.extend(true, {}, $item.data('lcf-registered-data'));
            switch (customFieldData.type) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'image':
                case 'file':
                    customFieldData.value = $item.find('> .meta-box-wrap input').val();
                    break;
                case 'wysiwyg':
                    customFieldData.value = WebEd.wysiwygGetContent($item.find('> .meta-box-wrap textarea'));
                    break;
                case 'textarea':
                    customFieldData.value = $item.find('> .meta-box-wrap textarea').val();
                    break;
                case 'checkbox':
                    customFieldData.value = [];
                    $item.find('> .meta-box-wrap input:checked').each(function () {
                        customFieldData.value.push($(this).val());
                    });
                    break;
                case 'radio':
                    customFieldData.value = $item.find('> .meta-box-wrap input:checked').val();
                    break;
                case 'select':
                    customFieldData.value = $item.find('> .meta-box-wrap select').val();
                    break;
                case 'repeater':
                    customFieldData.value = [];
                    let $repeaterItems = $item.find('> .meta-box-wrap > .lcf-repeater > .field-group-items > li');
                    $repeaterItems.each(function () {
                        let $current = $(this);
                        let fieldGroup = $current.find('> .field-line-wrapper > .field-group');
                        customFieldData.value.push(getRepeaterItemData(fieldGroup.find('> li')));
                    });
                    break;
                default:
                    customFieldData = null;
                    break;
            }
            return customFieldData;
        };

        let getRepeaterItemData = function ($where) {
            let data = [];
            $where.each(function () {
                let $current = $(this);
                data.push(getRepeaterItemValue($current));
            });
            return data;
        };

        let getRepeaterItemValue = function ($item) {
            let customFieldData = $.extend(true, {}, $item.data('lcf-registered-data'));
            switch (customFieldData.type) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'image':
                case 'file':
                    customFieldData.value = $item.find('> .repeater-item-input input').val();
                    break;
                case 'wysiwyg':
                    customFieldData.value = WebEd.wysiwygGetContent($item.find('> .repeater-item-input > .lcf-wysiwyg-wrapper > .wysiwyg-editor'));
                    break;
                case 'textarea':
                    customFieldData.value = $item.find('> .repeater-item-input textarea').val();
                    break;
                case 'checkbox':
                    customFieldData.value = [];
                    $item.find('> .repeater-item-input input:checked').each(function () {
                        customFieldData.value.push($(this).val());
                    });
                    break;
                case 'radio':
                    customFieldData.value = $item.find('> .repeater-item-input input:checked').val();
                    break;
                case 'select':
                    customFieldData.value = $item.find('> .repeater-item-input select').val();
                    break;
                case 'repeater':
                    customFieldData.value = [];
                    let $repeaterItems = $item.find('> .repeater-item-input > .lcf-repeater > .field-group-items > li');
                    $repeaterItems.each(function () {
                        let $current = $(this);
                        let fieldGroup = $current.find('> .field-line-wrapper > .field-group');
                        customFieldData.value.push(getRepeaterItemData(fieldGroup.find('> li')));
                    });
                    break;
                default:
                    customFieldData = null;
                    break;
            }
            return customFieldData;
        };

        _self.$_EXPORT_TO.closest('form').on('submit', function (event) {
            _self.$_EXPORT_TO.val(Helpers.jsonEncode(getFieldGroups()));
        });
    }
}

(function ($) {
    $(document).ready(function () {
        new UseCustomFields();
    });
})(jQuery);
