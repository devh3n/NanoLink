<?php

namespace N3x74;

use Medoo\Medoo;

class Url
{
    private ?Medoo $db;

    public function __construct(Medoo $db)
    {
        $this->db = $db;
    }

    private function generateCode(): string
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
    }

    public function isUrl($url): bool
    {
        $parts = parse_url($url);
        if ($parts === false)
        {
            return false;
        }

        $scheme = $parts['scheme'] ?? '';
        $host   = $parts['host']   ?? '';
        $path   = $parts['path']   ?? '';
        $query  = $parts['query']  ?? '';

        $scheme = strtolower($scheme);
        if ($scheme !== 'http' && $scheme !== 'https')
        {
            return false;
        }

        if (!preg_match('/^[a-z0-9.-]+\.[a-z]{2,}$/i', $host))
        {
            return false;
        }

        if ($path !== '')
        {
            $path = preg_replace_callback(
                '/[^A-Za-z0-9\-_.~\/]/u',
                fn($m) => rawurlencode($m[0]),
                $path
            );
        }

        $queryString = '';
        if ($query !== '')
        {
            parse_str($query, $params);
            foreach ($params as &$value)
            {
                $value = rawurlencode($value);
            }
            unset($value);
            $queryString = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        }

        $rebuilt = "$scheme://$host$path";
        if ($queryString !== '')
        {
            $rebuilt .= "?$queryString";
        }
        
        return filter_var($rebuilt, FILTER_VALIDATE_URL) !== false;
    }

    public function conversion(string $url): string
    {
        do {
            $code = $this->generateCode();
        } while ($this->db->has("urls", ["code" => $code]));

        $this->db->insert("urls", ["url" => $url, "code"=> $code]);

        return $code;
    }

    public function getUrl($code): string|null
    {
        return $this->db->get("urls", "url", ["code"=> $code]);
    }
}
