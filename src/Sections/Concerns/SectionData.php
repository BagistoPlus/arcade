<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use ArrayObject;
use Illuminate\Database\Eloquent\Collection;

/**
 * @inheritDoc
 */
class SectionData extends BlockData
{
    /**
     * @property-read Collection<BlockData> $allBlocks
     */
    protected $allBlocks;

    /**
     * @property-read Collection<BlockData> $blocks
     */
    protected $blocks;

    /**
     * @property-read array $blocksOrder
     */
    protected array $blocksOrder;

    public function __construct(string $id, array $data)
    {
        parent::__construct($id, $data);

        $blocks = $data['blocks'] ?? [];
        $this->blocksOrder = $data['blocks_order'] ?? array_keys($blocks);

        $this->allBlocks = collect($this->blocksOrder)
            ->map(function ($id) use ($blocks) {
                return new BlockData($id, $blocks[$id]);
            });

        $this->blocks = $this->allBlocks->filter(function ($block) {
            return ! $block->disabled;
        });
    }

    /**
     * Check if section have blocks of given types
     *
     * @param string|string[] $type
     * @return bool
     */
    public function hasBlockOfType($type)
    {
        $type = (array) $type;

        return $this->blocks->some(function ($block) use ($type) {
            return in_array($block->type, $type);
        });
    }

    /**
     * Get section blocks of given types
     *
     * @param string|string[] $type
     * @return Collection<BlockData>
     */
    public function blocksOfType($type)
    {
        $type = (array) $type;

        return $this->blocks->filter(function ($block) use ($type) {
            return in_array($block->type, $type);
        });
    }

    public function blockOfType(string $type)
    {
        return $this->blocksOfType($type)->first();
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'blocks' => $this->allBlocks->groupBy(function ($block) {
                return $block->id;
            })->map(function ($blocks) {
                return $blocks[0];
            }),
            'blocks_order' => $this->blocksOrder,
        ]);
    }
}
