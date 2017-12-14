<?php namespace WebEd\Base\CustomFields\Hook;

use WebEd\Base\CustomFields\Repositories\Contracts\CustomFieldRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldItemRepositoryContract;
use WebEd\Base\CustomFields\Repositories\CustomFieldRepository;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;
use WebEd\Base\CustomFields\Repositories\FieldItemRepository;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;

class StoreCustomFields
{
    /**
     * @var CustomFieldRepository
     */
    protected $customFieldRepository;

    /**
     * @var FieldGroupRepository
     */
    protected $fieldGroupRepository;

    /**
     * @var FieldItemRepository
     */
    protected $fieldItemRepository;

    /**
     * @var array|\Illuminate\Http\Request|string
     */
    protected $request;

    public function __construct()
    {
        $this->customFieldRepository = app(CustomFieldRepositoryContract::class);
        $this->fieldGroupRepository = app(FieldGroupRepositoryContract::class);
        $this->fieldItemRepository = app(FieldItemRepositoryContract::class);

        $this->request = request();
    }

    public function handleCreate($screenName, $result)
    {
        $this->handleUpdate($screenName, null, $result);
    }

    /**
     * @param string $screenName
     * @param int $id
     * @param int $result
     */
    public function handleUpdate($screenName, $id, $result)
    {
        $this->saveCustomFields($screenName, $result);
    }

    /**
     * @param $screenName
     * @param $id
     */
    protected function saveCustomFields($screenName, $id)
    {
        $data = $this->parseRawData($this->request->input('custom_fields', []));
        foreach ($data as $row) {
            $this->saveCustomField($screenName, $id, $row);
        }
    }

    /**
     * @param $screen
     * @param $id
     * @param array $data
     */
    protected function saveCustomField($screen, $id, array $data)
    {
        $currentMeta = $this->customFieldRepository->findWhere([
            'field_item_id' => $data['id'],
            'slug' => $data['slug'],
            'use_for' => $screen,
            'use_for_id' => $id,
        ]);

        $value = $this->parseFieldValue($data);

        if (!is_string($value)) {
            $value = json_encode($value);
        }

        $data['value'] = $value;

        if ($currentMeta) {
            $this->customFieldRepository->update($currentMeta, $data);
        } else {
            $data['use_for'] = $screen;
            $data['use_for_id'] = $id;
            $data['field_item_id'] = $data['id'];

            $this->customFieldRepository->create($data);
        }
    }

    /**
     * Get field value
     * @param $field
     * @return array|string
     */
    protected function parseFieldValue($field)
    {
        switch ($field['type']) {
            case 'repeater':
                if (!isset($field['value'])) {
                    return [];
                }

                $value = [];
                foreach ($field['value'] as $row) {
                    $groups = [];
                    foreach ($row as $item) {
                        $groups[] = [
                            'field_item_id' => $item['id'],
                            'type' => $item['type'],
                            'slug' => $item['slug'],
                            'value' => $this->parseFieldValue($item),
                        ];
                    }
                    $value[] = $groups;
                }
                return $value;
                break;
            case 'checkbox':
                $value = isset($field['value']) ? (array)$field['value'] : [];
                break;
            default:
                $value = isset($field['value']) ? $field['value'] : '';
                break;
        }
        return $value;
    }

    /**
     * @param $jsonString
     * @return array
     */
    protected function parseRawData($jsonString)
    {
        try {
            $fieldGroups = json_decode($jsonString, true) ?: [];
        } catch (\Exception $exception) {
            return [];
        }

        $result = [];
        foreach ($fieldGroups as $fieldGroup) {
            foreach ($fieldGroup['items'] as $item) {
                $result[] = $item;
            }
        }
        return $result;
    }
}
