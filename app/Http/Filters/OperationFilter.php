<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class OperationFilter extends AbstractFilter
{
    public const CODE = 'code';
    public const TYPE = 'type';
    public const IMPERATIVE_NAME = 'imperative_name';
    public const VERBAL_NAME = 'verbal_name';
    public const DOCUMENT_SECTION = 'document_section';
    public const DOCUMENT_SUBSECTION = 'document_subsection';
    public const START_DOCUMENT_PAGE = 'start_document_page';
    public const END_DOCUMENT_PAGE = 'end_document_page';
    public const ACTUAL_DOCUMENT_PAGE = 'actual_document_page';
    public const DOCUMENT_ID = 'document_id';

    protected function getCallbacks(): array
    {
        return [
            self::CODE => [$this, 'code'],
            self::TYPE => [$this, 'type'],
            self::IMPERATIVE_NAME => [$this, 'imperativeName'],
            self::VERBAL_NAME => [$this, 'verbalName'],
            self::DOCUMENT_SECTION => [$this, 'documentSection'],
            self::DOCUMENT_SUBSECTION => [$this, 'documentSubsection'],
            self::START_DOCUMENT_PAGE => [$this, 'startDocumentPage'],
            self::END_DOCUMENT_PAGE => [$this, 'endDocumentPage'],
            self::ACTUAL_DOCUMENT_PAGE => [$this, 'actualDocumentPage'],
            self::DOCUMENT_ID => [$this, 'documentId'],
        ];
    }

    public function code(Builder $builder, $value)
    {
        $builder->where(self::CODE, $value);
    }

    public function type(Builder $builder, $value)
    {
        $builder->where(self::TYPE, $value);
    }

    public function imperativeName(Builder $builder, $value)
    {
        $builder->where(self::IMPERATIVE_NAME, 'like', "%{$value}%");
    }

    public function verbalName(Builder $builder, $value)
    {
        $builder->where(self::VERBAL_NAME, 'like', "%{$value}%");
    }

    public function documentSection(Builder $builder, $value)
    {
        $builder->where(self::DOCUMENT_SECTION, $value);
    }

    public function documentSubsection(Builder $builder, $value)
    {
        $builder->where(self::DOCUMENT_SUBSECTION, $value);
    }

    public function startDocumentPage(Builder $builder, $value)
    {
        $builder->where(self::START_DOCUMENT_PAGE, $value);
    }

    public function endDocumentPage(Builder $builder, $value)
    {
        $builder->where(self::END_DOCUMENT_PAGE, $value);
    }

    public function actualDocumentPage(Builder $builder, $value)
    {
        $builder->where(self::ACTUAL_DOCUMENT_PAGE, $value);
    }

    public function documentId(Builder $builder, $value)
    {
        $builder->where(self::DOCUMENT_ID, $value);
    }
}
