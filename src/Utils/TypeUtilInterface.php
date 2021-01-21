<?php


namespace Apie\CompositeValueObjects\Utils;


interface TypeUtilInterface extends \Stringable
{
    public function fromNative($input);
    public function toNative($input);
    public function fromMissingValue();
    public function supports($input): bool;
    public function supportsToNative($input): bool;
    public function supportsFromNative($input): bool;
}