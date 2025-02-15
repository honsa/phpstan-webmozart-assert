<?php

namespace WebmozartAssertImpossibleCheck;

use Webmozart\Assert\Assert;

class Foo
{

	public function doFoo(string $s): void
	{
		Assert::stringNotEmpty($s);
		Assert::stringNotEmpty('');
	}

	/**
	 * @param mixed[] $b
	 */
	public function isInstanceOf(Bar $a, array $b): void
	{
		Assert::isInstanceOf($a, Bar::class);
		Assert::isInstanceOf($a, $a);
		Assert::nullOrIsInstanceOf($a, Bar::class);

		Assert::allIsInstanceOf($b, Bar::class);
		Assert::allIsInstanceOf($b, Bar::class);
	}

	public function notInstanceOf(Bar $a): void
	{
		Assert::notInstanceOf($a, Baz::class);
		Assert::notInstanceOf($a, Bar::class);
	}

	/**
	 * @param non-empty-string $b
	 * @param non-empty-string|null $e
	 */
	public function stringNotEmpty(string $a, string $b, string $c, ?string $d, ?string $e): void
	{
		Assert::stringNotEmpty(null);

		Assert::stringNotEmpty($a);
		Assert::stringNotEmpty($a);

		Assert::stringNotEmpty($b);

		Assert::nullOrStringNotEmpty($c);
		Assert::nullOrStringNotEmpty($c);

		Assert::nullOrStringNotEmpty($d);

		Assert::nullOrStringNotEmpty($e);
	}

	public function same(Bar $a, Bar $b): void
	{
		Assert::same($a, $b);
		Assert::same(new Baz(), new Baz());
		Assert::same(Baz::create(), Baz::create());
	}

	public function notSame(Bar $a, Bar $b): void
	{
		Assert::notSame($a, $b);
		Assert::notSame(new Baz(), new Baz());
		Assert::notSame(Baz::create(), Baz::create());
	}

	/**
	 * @param array<array> $a
	 */
	public function allCount(array $a): void
	{
		Assert::allCount($a, 2);
		Assert::allCount($a, 2);
	}

	public function nonEmptyStringAndSomethingUnknownNarrow($a, string $b, array $c, array $d): void
	{
		Assert::string($a);
		Assert::stringNotEmpty($a);
		Assert::uuid($a);
		Assert::uuid($a); // only this should report

		Assert::stringNotEmpty($b);
		Assert::contains($b, 'foo');
		Assert::contains($b, 'foo'); // only this should report
		Assert::contains($b, 'bar');

		Assert::allString($c);
		Assert::allStringNotEmpty($c);
		Assert::allUuid($c);
		Assert::allUuid($c); // only this should report

		Assert::allStringNotEmpty($d);
		Assert::allContains($d, 'foo');
		Assert::allContains($d, 'foo'); // only this should report
		Assert::allContains($d, 'bar');
	}

	public function implementsInterface($a, string $b, $c): void
	{
		Assert::implementsInterface($a, Bar::class);
		Assert::implementsInterface($a, Bar::class);

		Assert::implementsInterface($b, Bar::class);
		Assert::implementsInterface($b, Bar::class);

		Assert::implementsInterface($c, Unknown::class);
		Assert::implementsInterface($c, self::class);
	}

	/**
	 * @param class-string<\Exception> $name
	 */
	public function testInstanceOfClassString(\Exception $e, string $name): void
	{
		Assert::isInstanceOf($e, $name);
	}

	public function testStartsWith(string $a): void
	{
		Assert::startsWith("value", "val");
		Assert::startsWith("value", $a);
		Assert::startsWith("value", $a);
		Assert::startsWith("value", "bix");
	}

}

interface Bar {};

class Baz
{

	public static function create(): self
	{
		return new self();
	}

}
