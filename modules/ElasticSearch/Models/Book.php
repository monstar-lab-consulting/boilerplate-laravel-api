<?php

namespace Modules\ElasticSearch\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use ElasticquentTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    protected $fillable = [
        //
    ];

    /**
     * The elasticsearch settings.
     *
     * @var array
     */
    protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
        ],
    ];

    /**
     * GetIndexName function
     *
     * @return string
     */
    function getIndexName()
    {
        return 'books';
    }

    /**
     * GetTypeName function
     *
     * @return string
     */
    function getTypeName()
    {
        return 'books';
    }
}
