<?php
/**
 * Pagination Helper
 */

class Pagination {
    private $total_items;
    private $items_per_page;
    private $current_page;
    private $total_pages;
    
    public function __construct($total_items, $items_per_page = 10, $current_page = 1) {
        $this->total_items = $total_items;
        $this->items_per_page = $items_per_page;
        $this->current_page = max(1, intval($current_page));
        $this->total_pages = ceil($total_items / $items_per_page);
    }
    
    public function getOffset() {
        return ($this->current_page - 1) * $this->items_per_page;
    }
    
    public function getLimit() {
        return $this->items_per_page;
    }
    
    public function getTotalPages() {
        return $this->total_pages;
    }
    
    public function getCurrentPage() {
        return $this->current_page;
    }
    
    public function getPageNumbers() {
        $pages = [];
        for ($i = 1; $i <= $this->total_pages; $i++) {
            $pages[] = $i;
        }
        return $pages;
    }
    
    public function hasNextPage() {
        return $this->current_page < $this->total_pages;
    }
    
    public function hasPreviousPage() {
        return $this->current_page > 1;
    }
}
?>
