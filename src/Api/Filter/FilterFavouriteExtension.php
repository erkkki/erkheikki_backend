<?php

namespace App\Api\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\piRadio\FavouriteStation;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Uid\Uuid;

class FilterFavouriteExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Filter out rest and show only users favorites.
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void {

        if (FavouriteStation::class === $resourceClass) {
            $uuid = Uuid::v4();

            /** @var User $user */
            $user = $this->security->getUser();
            if ($user !== null) {
                $uuid = Uuid::fromString($user->getId());
            }


            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.user = :user', $rootAlias));
            $queryBuilder->setParameter('user', $uuid->toBinary());
        }
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        string $operationName = null,
        array $context = []
    ): void {
        if (FavouriteStation::class === $resourceClass) {
            $uuid = Uuid::v4();

            /** @var User $user */
            $user = $this->security->getUser();
            if ($user !== null) {
                $uuid = Uuid::fromString($user->getId());
            }


            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.user = :user', $rootAlias));
            $queryBuilder->setParameter('user', $uuid->toBinary());
        }
    }
}
