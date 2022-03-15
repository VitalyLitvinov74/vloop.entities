<?php


namespace vloop\entities\standarts\json\decorators;


use vloop\entities\standarts\json\decorators\links\ILink;
use vloop\entities\standarts\json\IJsonStandart;
use vloop\entities\standarts\json\JsonStandart;

class WithLinks implements IJsonStandart
{

    private $apiStandrt;
    private $links;

    /**
     * WithLinks constructor.
     * @param JsonStandart $apiFormat
     * @param ILink[] $linksList
     */
    public function __construct(JsonStandart $apiFormat, array $linksList)
    {
        $this->apiStandrt = $apiFormat;
        $this->links = $linksList;
    }

    public function printYourSelf(): array
    {
        $origin = $this->apiStandrt->printYourSelf();
        $linksApiObject = [];
        foreach ($this->links as $iLink) {
            $linksApiObject = array_merge(
                $linksApiObject,
                $iLink->printYourSelf()
            );
        }
        return array_merge([
            'links' => $linksApiObject
        ], $origin);
    }
}