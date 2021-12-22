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
                return new BlockData($id, $blocks[$id]);
            })->all();
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'blocks' => collect($this->blocks)->groupBy(function ($block) {
                return $block->id;
            })->map(function ($blocks) {
                return $blocks[0];
            }),
            'blocks_order' => $this->blocksOrder,
        ]);
    }
}
