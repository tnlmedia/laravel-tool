<?php

namespace TNLMedia\LaravelTool\Libraries;

class ContentSplitter
{
    /**
     * Source title
     *
     * @var string
     */
    protected string $title = '';

    /**
     * Source content
     *
     * @var string
     */
    protected string $content = '';

    /**
     * Source terms
     *
     * @var array
     */
    protected array $terms = [];

    /**
     * Config source title
     *
     * @param string $value
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;
        return $this;
    }

    /**
     * Config source content
     *
     * @param string $value
     * @return $this
     */
    public function setContent(string $value): self
    {
        $value = preg_replace('/<script[^>]*>(.*?)<\/script>/si', '', $value);
        $value = preg_replace('/<style[^>]*>(.*?)<\/style>/si', '', $value);
        $value = preg_replace('/<!--(.*?)-->/si', '', $value);
        $value = strip_tags($value);
        $value = str_replace(['&nbsp;', "\t"], ' ', $value);
        $value = str_replace(["\n", "\r"], ' ', $value);
        $value = preg_replace('/([\s]+)/i', ' ', $value);
        $value = trim($value);
        $this->content = $value;
        return $this;
    }

    /**
     * Config source terms
     *
     * @param array $value
     * @return $this
     */
    public function setTerm(array $value): self
    {
        $this->terms = array_map('strval', $value);
        return $this;
    }

    /**
     * Pick the most frequent term in content
     *
     * @return string
     */
    public function pickTerm(): string
    {
        $list = [];
        foreach ($this->terms as $item) {
            // Pass in title
            if (preg_match('/' . preg_quote($item, '/') . '/i', $this->title)) {
                continue;
            }

            // Count
            preg_match_all('/' . preg_quote($item, '/') . '/i', $this->content, $match);
            $list[$item] = count($match[0]);
        }
        arsort($list);
        return strval(array_key_first($list) ?? '');
    }

    /**
     * Get UTF-8 keyword from content
     *
     * @param int $pick
     * @return array
     */
    public function cutUtfKeyword(int $pick = 0): array
    {
        // Rules
        $rule_count = [
            7 => 2,
            6 => 2,
            5 => 2,
            4 => 2,
            3 => 3,
            2 => 3,
        ];
        $rule_black = [
            ' ',
            ' ',
            '—',
            '”',
            '…',
            '─',
            '▲',
            '△',
            '▼',
            '▽',
            '★',
            '☆',
            '　',
            '、',
            '。',
            '〈',
            '〉',
            '《',
            '》',
            '「',
            '」',
            '『',
            '』',
            '一些',
            '一個',
            '一定',
            '一張',
            '一樣',
            '一直',
            '一種',
            '一般',
            '一開始',
            '上',
            '下',
            '不僅',
            '不同',
            '不會',
            '不用',
            '不知',
            '不要',
            '不過',
            '也',
            '了',
            '人們',
            '什麼',
            '他們',
            '以',
            '你們',
            '你用',
            '使用',
            '來就',
            '來看',
            '來說',
            '個',
            '其',
            '別人',
            '加入',
            '原來',
            '原本',
            '受到',
            '另外',
            '可能',
            '吧',
            '呀',
            '哇',
            '哈',
            '哪',
            '啊',
            '啦',
            '喔',
            '嗯',
            '因此',
            '因為',
            '在',
            '大人物',
            '大家',
            '如何',
            '如此',
            '妳們',
            '對於',
            '得到',
            '您們',
            '成為',
            '我們',
            '或者',
            '方式',
            '是',
            '沒有',
            '由於',
            '當然',
            '的',
            '看來',
            '看見',
            '知道',
            '稱為',
            '符合',
            '第一',
            '終於',
            '結果',
            '而且',
            '而已',
            '自己',
            '要按',
            '見到',
            '認為',
            '起來',
            '這',
            '連結',
            '那',
            '部分',
            '間',
            '隻',
            '非常',
            '順便',
            '﹏',
            '！',
            '＇',
            '（',
            '）',
            '＊',
            '＋',
            '，',
            '－',
            '．',
            '．',
            '／',
            '０',
            '１',
            '２',
            '３',
            '４',
            '５',
            '６',
            '７',
            '９',
            '：',
            '；',
            '＜',
            '＞',
            '？',
            '＼',
            '＿',
            '～',
        ];

        // Clean to sentence
        $sentence = str_replace($rule_black, ' ', $this->content);
        $sentence = preg_replace('/[a-zA-Z0-9~!@#$%^&*()_+`\-=\[\]\\\{}|;\':\"<>?,.\/]+/i', ' ', $sentence);
        $sentence = preg_replace('/([\s]+)/i', ' ', $sentence);
        $sentence = explode(' ', $sentence);

        // Process per length
        $list = [];
        foreach ($rule_count as $limit_length => $limit_count) {
            // Sentence split to keyword
            $split = [];
            foreach ($sentence as $item) {
                $length = mb_strlen($item);
                if ($length < $limit_length) {
                    continue;
                }

                // Split
                for ($i = 0; $i <= $length - $limit_length; $i++) {
                    $keyword = mb_substr($item, $i, $limit_length);
                    $split[$keyword] = $split[$keyword] ?? 0;
                    $split[$keyword]++;
                }
            }

            // Get target words
            foreach ($split as $keyword => $count) {
                if ($count < $limit_count) {
                    continue;
                }

                foreach ($list as $list_keyword => $list_count) {
                    if (str_contains($list_keyword, $keyword)) {
                        // Drop shorter keyword
                        continue 2;
                    }
                }

                $list[$keyword] = ['count' => $count, 'length' => $limit_length];
            }
        }

        // Pick
        $list = array_keys($list);
        if ($pick > 0) {
            $list = array_slice($list, 0, $pick);
        }
        return $list;
    }

    /**
     * Get alphanumeric keyword from content
     *
     * @param int $pick
     * @return array
     */
    public function cutAlphanumericKeyword(int $pick = 0): array
    {
        // Rules
        $rule_count = [
            5 => 2,
            4 => 2,
            3 => 2,
            2 => 2,
            1 => 3,
        ];

        // Extract chars
        $sentence = [];
        preg_match_all('/[a-zA-Z0-9\-_. ]+/i', $this->content, $matches);
        foreach ($matches[0] as $pattern) {
            $pattern = trim($pattern);
            if (empty($pattern)) {
                continue;
            }

            $list = explode('  ', $pattern);
            foreach ($list as $item) {
                $item = trim($item);
                if (empty($item)) {
                    continue;
                }
                $sentence[] = array_filter(explode(' ', $item));
            }
        }

        // Process per length
        $case_map = [];
        $list = [];
        foreach ($rule_count as $limit_length => $limit_count) {
            // Sentence split to keyword
            $split = [];
            foreach ($sentence as $item) {
                $length = count($item);
                if ($length < $limit_length) {
                    continue;
                }

                // Split
                for ($i = 0; $i <= $length - $limit_length; $i++) {
                    $keyword = implode(' ', array_slice($sentence, $i, $length));
                    $keyword = $case_map[strtolower($keyword)] ?? $keyword;
                    $split[$keyword] = $split[$keyword] ?? 0;
                    $split[$keyword]++;
                    $case_map[strtolower($keyword)] = $keyword;
                }
            }

            // Get target words
            foreach ($split as $keyword => $count) {
                if ($count < $limit_count) {
                    continue;
                }

                foreach ($list as $list_keyword => $list_count) {
                    if (str_contains($list_keyword, $keyword)) {
                        // Drop shorter keyword
                        continue 2;
                    }
                }

                $list[$keyword] = ['count' => $count, 'length' => $limit_length];
            }
        }

        // Pick
        $list = array_keys($list);
        if ($pick > 0) {
            $list = array_slice($list, 0, $pick);
        }
        return $list;
    }

    /**
     * Sort callback
     *
     * @param $a
     * @param $b
     * @return int
     * @see https://www.php.net/manual/en/function.uasort.php
     */
    public static function sort($a, $b): int
    {
        if ($a['count'] < $b['count']) {
            return 1;
        }
        if ($a['count'] > $b['count']) {
            return -1;
        }
        if ($a['length'] < $b['length']) {
            return 1;
        }
        if ($a['length'] > $b['length']) {
            return -1;
        }
        return 0;
    }
}
