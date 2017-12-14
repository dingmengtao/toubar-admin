<?php namespace WebEd\Base\CustomFields\Support;

use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;

class CustomFieldSupport
{
    /**
     * @var array
     */
    protected $ruleGroups = [
        'basic' => [
            'items' => [

            ],
        ],
        'other' => [
            'items' => [

            ],
        ]
    ];

    /**
     * @var array|string
     */
    protected $rules = [];

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var \WebEd\Base\CustomFields\Repositories\FieldGroupRepository
     */
    protected $fieldGroupRepository;

    /**
     * @var bool
     */
    protected $isRenderedAssets = false;

    public function __construct()
    {
        $this->app = app();
        $this->fieldGroupRepository = $this->app->make(FieldGroupRepositoryContract::class);
    }

    /**
     * @param $groupName
     * @return $this
     */
    public function registerRuleGroup($groupName)
    {
        $this->ruleGroups[$groupName] = [
            'items' => []
        ];
        return $this;
    }

    /**
     * @param string $group
     * @param string $title
     * @param string $slug
     * @param \Closure|array $data
     * @return $this
     */
    public function registerRule($group, $title, $slug, $data)
    {
        if (!isset($this->ruleGroups[$group])) {
            $this->registerRuleGroup($group);
        }

        $this->ruleGroups[$group]['items'][$slug] = [
            'title' => $title,
            'slug' => $slug,
            'data' => []
        ];

        if (!is_array($data)) {
            $data = [$data];
        }

        $this->ruleGroups[$group]['items'][$slug]['data'] = $data;

        return $this;
    }

    /**
     * @param string $group
     * @param string $title
     * @param string $slug
     * @param \Closure|array $data
     * @return $this
     */
    public function expandRule($group, $title, $slug, $data)
    {
        if (!isset($this->ruleGroups[$group]['items'][$slug]['data']) || !$this->ruleGroups[$group]['items'][$slug]['data']) {
            return $this->registerRule($group, $title, $slug, $data);
        }

        if (!is_array($data)) {
            $data = [$data];
        }

        $this->ruleGroups[$group]['items'][$slug]['data'] = array_merge($this->ruleGroups[$group]['items'][$slug]['data'], $data);

        return $this;
    }

    /**
     * Resolve all rule data from closure into array
     * @return array
     */
    protected function resolveGroups()
    {
        foreach ($this->ruleGroups as $groupKey => &$group) {
            foreach ($group['items'] as $type => &$item) {
                $data = [];

                foreach ($item['data'] as $datum) {
                    if ($datum instanceof \Closure) {
                        $resolvedClosure = call_user_func($datum);
                        if (is_array($resolvedClosure)) {
                            $data = array_unique(array_merge($data, $resolvedClosure));
                        }
                    } elseif (is_array($datum)) {
                        $data = array_unique(array_merge($data, $datum));
                    }
                }

                $item['data'] = $data;
            }
        }

        return $this->ruleGroups;
    }

    /**
     * @param array|string $rules
     * @return $this
     */
    public function setRules($rules)
    {
        if (!is_array($rules)) {
            $this->rules = json_decode($rules, true);
        } else {
            $this->rules = $rules;
        }
        return $this;
    }

    /**
     * @param string|array $ruleName
     * @param $value
     * @return $this
     */
    public function addRule($ruleName, $value = null)
    {
        if (is_array($ruleName)) {
            $rules = $ruleName;
        } else {
            $rules = [$ruleName => $value];
        }
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    /**
     * @param array $ruleGroups
     * @return bool
     */
    protected function checkRules(array $ruleGroups)
    {
        if (!$ruleGroups) {
            return false;
        }
        foreach ($ruleGroups as $group) {
            if ($this->checkEachRule($group)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $ruleGroup
     * @return bool
     */
    protected function checkEachRule(array $ruleGroup)
    {
        foreach ($ruleGroup as $ruleGroupItem) {
            if (!isset($this->rules[$ruleGroupItem['name']])) {
                return false;
            }
            if ($ruleGroupItem['type'] == '==') {
                if (is_array($this->rules[$ruleGroupItem['name']])) {
                    $result = in_array($ruleGroupItem['value'], $this->rules[$ruleGroupItem['name']]);
                } else {
                    $result = $ruleGroupItem['value'] == $this->rules[$ruleGroupItem['name']];
                }
            } else {
                if (is_array($this->rules[$ruleGroupItem['name']])) {
                    $result = !in_array($ruleGroupItem['value'], $this->rules[$ruleGroupItem['name']]);
                } else {
                    $result = $ruleGroupItem['value'] != $this->rules[$ruleGroupItem['name']];
                }
            }
            if (!$result) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $morphClass
     * @param $morphId
     * @return array
     */
    public function exportCustomFieldsData($morphClass, $morphId)
    {
        $fieldGroups = $this->fieldGroupRepository->getFieldGroups([
            'status' => 1
        ]);

        $result = [];

        foreach ($fieldGroups as $row) {
            if ($this->checkRules(json_decode($row->rules, true))) {
                $result[] = [
                    'id' => $row->id,
                    'title' => $row->title,
                    'items' => $this->fieldGroupRepository->getFieldGroupItems($row->id, null, true, $morphClass, $morphId),
                ];
            }
        }

        return $result;
    }

    /**
     * Render data
     * @return string
     */
    public function renderRules()
    {
        return view('webed-custom-fields::admin._script-templates.rules', [
            'ruleGroups' => $this->resolveGroups()
        ])->render();
    }

    /**
     * @param array $boxes
     * @return string
     */
    public function renderCustomFieldBoxes(array $boxes)
    {
        return view('webed-custom-fields::admin.custom-fields-boxes-renderer', [
            'customFieldBoxes' => json_encode($boxes),
        ])->render();
    }

    /**
     * Echo the custom fields assets
     */
    public function renderAssets()
    {
        if (!$this->isRenderedAssets) {
            echo view('webed-custom-fields::admin._script-templates.render-custom-fields')->render();
            $this->isRenderedAssets = true;
        }
        return;
    }
}
