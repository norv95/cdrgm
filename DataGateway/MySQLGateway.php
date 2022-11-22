<?php

namespace App\DataGateway;

use App\DataGateway\Client\MySQLDBClient;
use App\Model\AddressModel;
use App\Model\UserModel;
use App\Serializer\FormatType;
use App\Serializer\SerializerFactory;

class MySQLGateway
{
    private \PDO $conn;

    public function __construct(private MySQLDBClient $client, private SerializerFactory $serializerFactory)
    {
    }

    /**
     * Get registered users for the period
     * @param array $params
     * @return array
     */
    public function getUserRegistered(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd) : array
    {
        $sql = "SELECT * FROM users where users.register_time " .
               "BETWEEN {$dateStart->format('Y-m-d H:i:s')} AND {$dateEnd->format('Y-m-d H:i:s')}";

        /*
         * since the project doesn't have a real database the next code
         * is provided only for the logic demonstration purpose
         */

        /*$stmt = $this->conn->query($sql);
        $usersData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = [];
        foreach($usersData as $userData) {
            //perform UserModel creation from $userData with result stored on $user variable
            $users[] = $user
        }
        */

        /*** Emulate users data */
        $users = [
            [
                'id' => 1,
                'firstName' => 'Maxime',
                'secondName' => 'Nienow',
                'email' => 'sherwood@rosamond.me',
                'phone' => '2100676132',
                'registered_at' => '10.11.2021 14:42',
                'address' => [
                    'id' => 1,
                    'city' => 'Aliyaview',
                    'street' => 'Ellsworth Summit',
                    'building' => '62',
                    'zipcode' => '45169'
                ]
            ],
            [
                'id' => 2,
                'firstName' => 'Kurtis',
                'secondName' => 'Weissnat',
                'email' => 'telly.hoeger@billy.biz',
                'phone' => '5864936943',
                'registered_at' => '01.02.2021 11:21',
                'address' => [
                    'id' => 2,
                    'city' => 'Howemouth',
                    'street' => 'Rex Trail',
                    'building' => '33',
                    'zipcode' => '58804-1099'
                ]
            ],
            [
                'id' => 3,
                'firstName' => 'Dennis',
                'secondName' => 'Schulist',
                'email' => 'karley_dach@jasper.info',
                'phone' => '14779358478',
                'registered_at' => '06.08.2021 10:11',
                'address' => [
                    'id' => 3,
                    'city' => 'South Christy',
                    'street' => 'Norberto Crossing',
                    'building' => '11',
                    'zipcode' => '23505-1337'
                ]
            ],
            [
                'id' => 4,
                'firstName' => 'Chelsey',
                'secondName' => 'Dietrich',
                'email' => 'lucio_hettinger@annie.ca',
                'phone' => '2549541289',
                'registered_at' => '16.03.2022 12:05',
                'address' => [
                    'id' => 4,
                    'city' => 'Roscoeview',
                    'street' => 'Skiles Walks',
                    'building' => '54',
                    'zipcode' => '33263'
                ]
            ],
            [
                'id' => 5,
                'firstName' => 'Patricia',
                'secondName' => 'Lebsack',
                'email' => 'julianne.oconner@kory.org',
                'phone' => '4931709623',
                'registered_at' => '23.04.2022 20:05',
                'address' => [
                    'id' => 5,
                    'city' => 'South Elvis',
                    'street' => 'Hoeger Mall',
                    'building' => '23',
                    'zipcode' => '53919-4257'
                ]
            ]
        ];

        $serializer = $this->serializerFactory->create(FormatType::JSON);
        return $serializer->deserialize(json_encode($users), UserModel::class );
    }
}
