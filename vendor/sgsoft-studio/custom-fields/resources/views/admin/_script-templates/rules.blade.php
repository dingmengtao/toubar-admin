<script type="text/x-custom-template" id="rules_group_template">
    <div class="line rule-line mb10">
        <select class="form-control pull-left rule-a">
            @foreach($ruleGroups as $key => $row)
                <optgroup label="{{ trans('webed-custom-fields::rules.groups.' . $key) }}">
                    @foreach($row['items'] as $item)
                        <option value="{{ $item['slug'] or '' }}">{{ $item['title'] or '' }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <select class="form-control pull-left rule-type">
            <option value="==">{{ trans('webed-custom-fields::base.form.rules.is_equal_to') }}</option>
            <option value="!=">{{ trans('webed-custom-fields::base.form.rules.is_not_equal_to') }}</option>
        </select>
        <div class="rules-b-group pull-left">
            @foreach($ruleGroups as $key => $row)
                @foreach($row['items'] as $item)
                    <select class="form-control rule-b" data-rel="{{ $item['slug'] or '' }}">
                        @foreach($item['data'] as $keyData => $rowData)
                            <option value="{{ $keyData or '' }}">{{ $rowData or '' }}</option>
                        @endforeach
                    </select>
                @endforeach
            @endforeach
        </div>
        <a class="location-add-rule-and location-add-rule btn yellow-lemon pull-left" href="#">
            {{ trans('webed-custom-fields::base.form.rules.and') }}
        </a>
        <a href="#" title="" class="remove-rule-line"><span>&nbsp;</span></a>
        <div class="clearfix"></div>
    </div>
</script>

<script type="text/x-custom-template" id="rules_line_group_template">
    <div class="line-group" data-text="{{ trans('webed-custom-fields::base.form.rules.or') }}"></div>
</script>