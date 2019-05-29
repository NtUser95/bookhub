<?php

namespace Widgets\Pagination;

/**
 * Класс для генерирования пагинации
 */
class Pagination
{

    /**
     * @var int
     */
    private $total_elements;
    /**
     * @var int
     */
    private $elements_per_page;
    /**
     * @var int
     */
    private $current_page;
    /**
     * @var int
     */
    private $total_pages;

    /**
     * Pagination constructor.
     * @param int $total_elements_amount Общее количество элементов
     * @param int $elements_per_page Количество элементов на одной странице
     * @param int $current_page Текущая страница
     * @return string готовый HTML-код блока пагинации
     */
    public function __construct(int $total_elements_amount, int $elements_per_page = 10, int $current_page = 1)
    {
        $this->total_elements = $total_elements_amount;
        $this->elements_per_page = $elements_per_page;
        $this->current_page = $current_page > 0 ? $current_page : 1;
        $this->total_pages = ceil($total_elements_amount / $elements_per_page);
    }

    /**
     * Возвращает готовый HTML пагинации
     */
    public function getPagination(): string
    {
        //return $this->total_pages <= 10 ? $this->generateSimplyPagination() : $this->generateFullPagination();
        return $this->generateSimplyPagination();
    }

    private function generateSimplyPagination(): string
    {
        $html = '';
        if ($this->total_pages > 1) {
            for ($i = 1; $i <= $this->total_pages; $i++) {
                $isActive = $i === $this->current_page ? 'pagination-active-btn' : '';
                $html .= '<a class="pagination-btn ' . $isActive . '" onclick="getPage(' . $i . ');">' . $i . '</a>';
            }
        }

        return $html;
    }

    private function generateFullPagination(): string
    {
        $html = '';
        for ($i = 1; $i <= $this->total_pages; $i++) {
            $html .= '<a class="pagination-btn" onclick="getPage(' . $i . ');">' . $i . '</a>';
        }

        return $html;
    }
}