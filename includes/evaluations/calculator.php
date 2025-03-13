<?php
namespace CJM\Evaluations;

defined('ABSPATH') || exit;

class Calculator
{
    public static function weighted_average(array $scores, array $weights): float
    {
        $total = 0;
        $weight_sum = 0;

        foreach ($scores as $section => $score) {
            $weight = $weights[$section] ?? 1.0;
            $total += $score * $weight;
            $weight_sum += $weight;
        }

        return $weight_sum > 0 ? round($total / $weight_sum, 2) : 0;
    }

    public static function calculate_percentiles(array $scores): array
    {
        sort($scores);
        $count = count($scores);
        $percentiles = [];
        
        foreach ($scores as $index => $score) {
            $percentiles[] = round(($index + 1) / $count * 100, 2);
        }
        
        return $percentiles;
    }

    public static function normalize_scores(array $raw_scores): array
    {
        $max = max($raw_scores);
        return array_map(function($score) use ($max) {
            return $max > 0 ? $score / $max : 0;
        }, $raw_scores);
    }
}