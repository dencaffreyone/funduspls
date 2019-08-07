<?php

namespace App\DQL;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class TypeFunction extends FunctionNode
{

    /**
     * @var string
     */
    public $dqlAlias;

    public function getSql(SqlWalker $sqlWalker): string
    {
        /** @var ClassMetadataInfo $class */
        $class = $sqlWalker->getQueryComponent($this->dqlAlias)['metadata'];
        $tableAlias = $sqlWalker->getSQLTableAlias($class->getTableName(), $this->dqlAlias);

        if (!isset($class->discriminatorColumn['name'])) {
            $message = 'TYPE() only supports entities with a discriminator column.';
            throw QueryException::semanticalError($message);
        }

        return $tableAlias . '.' . $class->discriminatorColumn['name'];
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dqlAlias = $parser->IdentificationVariable();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}