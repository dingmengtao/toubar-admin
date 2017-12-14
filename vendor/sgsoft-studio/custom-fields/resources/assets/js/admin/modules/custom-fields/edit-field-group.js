class ManageCustomFields {
    constructor() {
        this.$body = $('body');
        this.RULES_GROUP_TEMPLATE_HTML = $('#rules_group_template').html();

        let _self = this;

        /**
         * Pass data to form when submit
         */
        this.$body.on('submit', '.form-update-field-group', function (event) {
            //event.preventDefault();
            let dataRules = JSON.stringify(_self.exportRulesToJson());
            let dataFields = JSON.stringify(_self.exportFieldsToJson());
            $('#custom_fields_rules').html(dataRules).val(dataRules);
            $('#custom_fields').html(dataFields).val(dataFields);
        });

        this.handleRules();
        this.handleFieldGroups();
    }

    handleRules() {
        let _self = this;

        let CURRENT_RULES = $.parseJSON($('#custom_fields_rules').val());
        let $_GLOBAL_TEMPLATE = $(_self.RULES_GROUP_TEMPLATE_HTML),
            LINE_GROUP_TEMPLATE = $('#rules_line_group_template').html(),
            $_GROUP_CONTAINER = $('.line-group-container');

        /**
         * Add new rule
         */
        _self.$body.on('click', '.location-add-rule', function (event) {
            event.preventDefault();
            let $current = $(this);
            let $template = $_GLOBAL_TEMPLATE.clone();

            if ($current.hasClass('location-add-rule-and')) {
                $current.closest('.line-group').append($template);
            } else {
                let $group = $(LINE_GROUP_TEMPLATE);

                $group.append($template);
                $_GROUP_CONTAINER.append($group);
            }
            $template.find('.rule-a').trigger('change');
        });

        /**
         * Change the rule-a
         */
        _self.$body.on('change', '.rule-a', function (event) {
            event.preventDefault();
            let $current = $(this);
            let $parent = $current.closest('.rule-line');
            $parent.find('.rules-b-group select').addClass('hidden');
            $parent.find('.rules-b-group select[data-rel="' + $current.val() + '"]').removeClass('hidden');
        });

        /**
         * Remove rule
         */
        _self.$body.on('click', '.remove-rule-line', function (event) {
            event.preventDefault();
            let $current = $(this);
            let $parent = $current.closest('.rule-line');
            let $lineGroup = $current.closest('.line-group');
            if ($lineGroup.find('.rule-line').length < 2) {
                $lineGroup.remove();
            } else {
                $parent.remove();
            }
        });

        /**
         * Init data when page loaded
         */
        if (CURRENT_RULES.length < 1) {
            $('.location-add-rule').trigger('click');
        } else {
            CURRENT_RULES.forEach(function (rules, indexRule) {
                let $group = $(LINE_GROUP_TEMPLATE);
                rules.forEach(function (item, index) {
                    let $template = $_GLOBAL_TEMPLATE.clone();
                    $template.find('.rule-a').val(item.name);
                    $template.find('.rule-type').val(item.type);
                    $template.find('.rule-b:not([data-rel="' + item.name + '"])').addClass('hidden');
                    $template.find('.rule-b[data-rel="' + item.name + '"]').val(item.value);
                    $group.append($template);
                });
                $_GROUP_CONTAINER.append($group);
            });
        }
    }

    handleFieldGroups() {
        let _self = this;

        let totalAdded = 0;

        let CUSTOM_FIELDS_DATA = $.parseJSON($('#custom_fields').val());

        /**
         * Deleted fields
         * @type {Array}
         */
        let DELETED_FIELDS = [];

        /**
         * Template of new field item
         * @type {any}
         */
        let NEW_FIELD_TEMPLATE = $('#_new-field-source_template').html();

        /**
         * Get all option templates
         * @type {{repeater: (any), defaultValue: (any), defaultValueTextarea: (any), placeholderText: (any), wysiwygToolbar: (any), selectChoices: (any), buttonLabel: (any)}}
         */
        let FIELD_OPTIONS = {
            repeater: $('#_options-repeater_template').html(),
            defaultValue: $('#_options-defaultvalue_template').html(),
            defaultValueTextarea: $('#_options-defaultvaluetextarea_template').html(),
            placeholderText: $('#_options-placeholdertext_template').html(),
            wysiwygToolbar: $('#_options-wysiwygtoolbar_template').html(),
            selectChoices: $('#_options-selectchoices_template').html(),
            buttonLabel: $('#_options-buttonlabel_template').html(),
            rows: $('#_options-rows_template').html()
        };

        /**
         * Get related options of current field type
         * @param value
         * @returns {string}
         */
        let getOptions = function (value) {
            let htmlSrc = '';
            switch (value) {
                case 'text':
                case 'email':
                case 'password':
                case 'number':
                    htmlSrc += FIELD_OPTIONS.defaultValue + FIELD_OPTIONS.placeholderText;
                    break;
                case 'image':
                case 'file':
                    return '';
                    break;
                case 'textarea':
                    htmlSrc += FIELD_OPTIONS.defaultValueTextarea + FIELD_OPTIONS.placeholderText + FIELD_OPTIONS.rows;
                    break;
                case 'wysiwyg':
                    htmlSrc += FIELD_OPTIONS.defaultValueTextarea + FIELD_OPTIONS.wysiwygToolbar;
                    break;
                case 'select':
                    htmlSrc += FIELD_OPTIONS.selectChoices + FIELD_OPTIONS.defaultValue;
                    break;
                case 'checkbox':
                    htmlSrc += FIELD_OPTIONS.selectChoices;
                    break;
                case 'radio':
                    htmlSrc += FIELD_OPTIONS.selectChoices;
                    break;
                case 'repeater':
                    htmlSrc += FIELD_OPTIONS.repeater + FIELD_OPTIONS.buttonLabel;
                    break;
                default:

                    break;
            }

            return htmlSrc;
        };

        /**
         * @param target
         */
        let reloadOrderNumber = function (target) {
            target.each(function (index, el) {
                let current = $(this);
                let index_css = index + 1;
                current.attr('data-position', index_css);
            });
        };

        let setOrderNumber = function (target, number) {
            target.attr('data-position', number || target.index() + 1);
        };

        let getNewFieldTemplate = function (optionType) {
            return NEW_FIELD_TEMPLATE.replace(/___options___/gi, getOptions(optionType || 'text'));
        };

        /**
         * Toggle show/hide content
         */
        _self.$body.on('click', '.show-item-details', function (event) {
            event.preventDefault();
            let parent = $(this).closest('li');
            $(this).toggleClass('active');
            parent.toggleClass('active');
        });
        _self.$body.on('click', '.btn-close-field', function (event) {
            event.preventDefault();
            let parent = $(this).closest('li');
            parent.toggleClass('active');
            parent.find('> .field-column .show-item-details').toggleClass('active');
        });

        /**
         * Add field
         */
        _self.$body.on('click', '.btn-add-field', function (event) {
            event.preventDefault();
            let $current = $(this);

            totalAdded++;

            let target = $current.closest('.add-new-field').find('> .sortable-wrapper');

            let $template = $(getNewFieldTemplate());

            target.append($template);

            $template.find('.line[data-option=title] input[type=text]').focus();

            setOrderNumber($template);

            //reloadOrderNumber(target.find('> li'));
            $template.find('.sortable-wrapper').sortable();
        });

        /**
         * Change field type
         */
        _self.$body.on('change', '.change-field-type', function (event) {
            event.preventDefault();
            let $current = $(this);
            let parent = $current.closest('.item-details');
            let target = parent.find('> .options');

            target.html(getOptions($current.val()));
        });

        /**
         * Change the related columns title
         */
        _self.$body.on('change blur', '.line[data-option=slug] input[type=text]', function (event) {
            let $current = $(this);
            let text = WebEd.stringToSlug($current.val(), '_');
            let $parent = $current.closest('.line');

            $parent.closest('.ui-sortable-handle').find('> .field-column .field-slug').text(text);

            $current.val(text);
        });
        _self.$body.on('change blur', '.line[data-option=type] select', function (event) {
            let $current = $(this);
            let text = WebEd.stringToSlug($current.val(), '_');
            let $parent = $current.closest('.line');

            $parent.closest('.ui-sortable-handle').find('> .field-column .field-type').text($current.find('option[value="' + text + '"]').text());

            $current.val(text);
        });
        _self.$body.on('change blur', '.line[data-option=title] input[type=text]', function (event) {
            let $current = $(this);
            let $parent = $current.closest('.line');
            let $nameSlugField = $parent.find('~ .line[data-option=slug] input[type=text]');
            let text = $current.val();

            /**
             * Change the line title
             */
            $parent.closest('.ui-sortable-handle').find('> .field-column .field-label').text(text);

            /**
             * Change field name
             */
            if (!$nameSlugField.val()) {
                $nameSlugField.val(WebEd.stringToSlug(text, '_')).trigger('change');
            }
        });

        /**
         * Delete field
         */
        $('#deleted_items').val('');
        _self.$body.on('click', '.btn-remove', function (event) {
            event.preventDefault();
            let $parent = $(this).closest('.ui-sortable-handle');
            let $grandParent = $parent.parent();
            DELETED_FIELDS.push($parent.data('id'));
            $parent.animate({
                    top: -60,
                    left: 60,
                    opacity: 0.3
                },
                300,
                function () {
                    $parent.remove();
                    reloadOrderNumber($grandParent.find('> li'));
                });
            $('#deleted_items').val(JSON.stringify(DELETED_FIELDS));
        });

        /**
         *
         * @param fields
         * @param $appendTo
         */
        let initFields = function (fields, $appendTo) {
            /**
             * Enable sortable
             */
            $appendTo.sortable();

            fields.forEach(function (field, indexField) {
                let $template = $(getNewFieldTemplate(field.type || 'text'));
                $template.data('id', field.id || 0);
                $template.find('.line[data-option=type] select').val(Helpers.arrayGet(field, 'type', 'text'));
                $template.find('.line[data-option=title] input').val(Helpers.arrayGet(field, 'title', ''));
                $template.find('.line[data-option=slug] input').val(Helpers.arrayGet(field, 'slug', ''));
                $template.find('.line[data-option=instructions] textarea').val(Helpers.arrayGet(field, 'instructions', ''));

                $template.find('.line[data-option=defaultvalue] input').val(Helpers.arrayGet(field.options, 'defaultValue', ''));
                $template.find('.line[data-option=defaultvaluetextarea] textarea').val(Helpers.arrayGet(field.options, 'defaultValueTextarea', ''));
                $template.find('.line[data-option=placeholdertext] input').val(Helpers.arrayGet(field.options, 'placeholderText', ''));
                $template.find('.line[data-option=wysiwygtoolbar] select').val(Helpers.arrayGet(field.options, 'wysiwygToolbar', 'basic'));
                $template.find('.line[data-option=selectchoices] textarea').val(Helpers.arrayGet(field.options, 'selectChoices', ''));
                $template.find('.line[data-option=buttonlabel] input').val(Helpers.arrayGet(field.options, 'buttonLabel', ''));
                $template.find('.line[data-option=rows] input').val(Helpers.arrayGet(field.options, 'rows', ''));

                $template.find('.field-label').html(Helpers.arrayGet(field, 'title', 'Text'));
                $template.find('.field-slug').html(Helpers.arrayGet(field, 'slug', 'text'));
                $template.find('.field-type').html(Helpers.arrayGet(field, 'type', 'text'));

                $template.removeClass('active');
                $template.attr('data-position', (indexField + 1));

                initFields(field.items, $template.find('.sortable-wrapper'));

                $appendTo.append($template);
            });
        };
        initFields(CUSTOM_FIELDS_DATA, $('.sortable-wrapper'));
    }

    exportRulesToJson() {
        let result = [];

        $('.custom-fields-rules .line-group-container .line-group').each(function () {
            let $current = $(this);
            let lineGroupData = [];
            $current.find('.rule-line').each(function (index, element) {
                let $currentLine = $(this);

                let data = {
                    name: $currentLine.find('.rule-a').val(),
                    type: $currentLine.find('.rule-type').val(),
                    value: $currentLine.find('.rule-b:not(.hidden)').val()
                };
                lineGroupData.push(data);
            });
            if (lineGroupData.length > 0) {
                result.push(lineGroupData);
            }
        });

        return result;
    }

    exportFieldsToJson() {
        let result = [];

        let getAllFields = function ($from, $pushTo) {
            $from.each(function (index, element) {
                let object = {};
                let $current = $(this);

                object.id = $current.data('id') || 0;
                object.title = $current.find('> .item-details > .line[data-option=title] input[type=text]').val() || null;
                object.slug = $current.find('> .item-details > .line[data-option=slug] input[type=text]').val() || null;
                object.instructions = $current.find('> .item-details > .line[data-option=instructions] textarea').val() || null;
                object.type = $current.find('> .item-details > .line[data-option=type] select').val() || null;
                object.options = {
                    defaultValue: $current.find('> .item-details > .options > .line[data-option=defaultvalue] input[type=text]').val() || null,
                    defaultValueTextarea: $current.find('> .item-details > .options > .line[data-option=defaultvaluetextarea] textarea').val() || null,
                    placeholderText: $current.find('> .item-details > .options > .line[data-option=placeholdertext] input[type=text]').val() || null,
                    wysiwygToolbar: $current.find('> .item-details > .options > .line[data-option=wysiwygtoolbar] select').val() || null,
                    selectChoices: $current.find('> .item-details > .options > .line[data-option=selectchoices] textarea').val() || null,
                    buttonLabel: $current.find('> .item-details > .options > .line[data-option=buttonlabel] input[type=text]').val() || null,
                    rows: $current.find('> .item-details > .options > .line[data-option=rows] input[type=number]').val() || null
                };
                object.items = [];

                getAllFields($current.find('> .item-details > .options > .line[data-option=repeater] > .col-xs-9 > .add-new-field > .sortable-wrapper > .ui-sortable-handle'), object.items);

                $pushTo.push(object);
            });
        };

        getAllFields($('#custom_field_group_items > .ui-sortable-handle'), result);

        return result;
    }
}

(function ($) {
    $(window).load(function () {
        new ManageCustomFields();
    });
})(jQuery);
