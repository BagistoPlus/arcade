<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

/**
 * @inheritDoc
 *
 * @property-read BlockData[] $blocks
 * @property-read array $blocksOrder
 */
class SectionData extends BlockData
{
    protected array $blocks;
    protected array $blocksOrder;

    public function __construct(string $id, array $data)
    {
        parent::__construct($id, $data);

        $blocks = $data['blocks'] ?? [];
        $this->blocksOrder = $data['blocks_order'] ?? array_keys($blocks);

        $this->blocks = collect($this->blocksOrder)
            ->map(function ($id) use ($blocks) {
                return new BlockData($id, array_merge($blocks[$id], ['id' => $id]));
            })->all();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'blocks' => collect($this->blocks)->keyBy('id')->map(function ($block) {
                return $block->toArray();
            })->toArray(),
            'blocks_order' => $this->blocksOrder,
        ];
    }
}
