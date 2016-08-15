<?php
namespace Domain\Attachment\Source;

final class ExternalSource implements Source
{
    const SOURCE_CODE = 'external';

    /** @var string */
    private $url;

    public function __construct(string $origURL)
    {
        $this->url = $origURL;
    }

    public function getOrigURL(): string
    {
        return $this->url;
    }

    public function toJSON(): array
    {
        return [
            'origURL' => $this->getOrigURL(),
        ];
    }

    public function getCode(): string
    {
        return self::SOURCE_CODE;
    }
}