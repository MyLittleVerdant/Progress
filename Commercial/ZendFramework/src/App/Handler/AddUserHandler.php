<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\User;
use App\Repository\UserRepository;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AddUserHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userRepository = new UserRepository();

        $user = new User();
        $user->setId(123);
        $user->setAccessToken(
            "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImIyMDlhNGNhZDUzNDA2MTlhMjJlZjdiZDdlZTYyYzJlNjk3ZjMyZmFlNGY4YTBjNGZmN2Y5MmM3Y2RjNzc3OGQzNWRmM2RmZDE5MTI0N2M0In0.eyJhdWQiOiJkNGQzMTkzNy0zN2NmLTRiMjAtOTkzNi03NDY0OWU3YmZkNDciLCJqdGkiOiJiMjA5YTRjYWQ1MzQwNjE5YTIyZWY3YmQ3ZWU2MmMyZTY5N2YzMmZhZTRmOGEwYzRmZjdmOTJjN2NkYzc3NzhkMzVkZjNkZmQxOTEyNDdjNCIsImlhdCI6MTY2OTk4MDMxNywibmJmIjoxNjY5OTgwMzE3LCJleHAiOjE2NzAwNjY3MTcsInN1YiI6Ijg4OTM2MjciLCJhY2NvdW50X2lkIjozMDY2NjU0MywiYmFzZV9kb21haW4iOiJrb21tby5jb20iLCJzY29wZXMiOlsicHVzaF9ub3RpZmljYXRpb25zIiwiY3JtIiwibm90aWZpY2F0aW9ucyJdfQ.q-rQVn5OpqXRWncdokTtZydfQA80H-hy_DYhGa-oPGfxBNWZ4Xp6USXkuFaI_oVspEtW47iXQIQz7wOR5NBtrmkwuI7u_EnZS75tQwkw0n9gZ6cnN7aV-JYYB1iZSHx_tzOzCTzxDSi3-gSouf-_6NPOF3jOrn_CN0MaGd1RniDnAWn-aS0a64gnf9iBSyjJVBNZF9Og_ogquLXgh37PezhP4TLV3Y8JcRRI3C6Dt9GSQNtEW-OF_WsewgDnnsLBNIaoj5FKdvF9p2uNH0ze4Z-D_F1gAxjbL4wsGrQG6EzwJ3fH_3NFIxgx81Msn0VY_SGm7biBIXPKuLFaN6HRGg"
        );
        $user->setRefreshToken(
            "def5020023b06cb77439eabc4eacd9361d1015bc021d6314570c1cd8bd238ff98c0ce1e15d0d59b7fd9ed694e349ecbc70df09e147f0039e3f711d58ef9f7dbd5dc1c8745a545c151e913ec60acc270b88b581a4e5608eae53ba967f4b24d7814073d2603fb5d58684d223a4e58fd66b37bf142147501782a6f154ea364bccde7ab9f4524adcfadb039960fbe1bd4ca22120929e05c742bce687062ffaeb51e546fcfaf31421f2e8763204f0a8da5417603cfc4c864ded1d0c28a654f3d6e56837696e0e6884d1612f1c9d91d4083d96a5bee3e37356b7a7b4635541a77bc5e530795d913cc38b1a4b0e13d30c34a984294a67493b410cce93c84eb34a03702665ae77d7c1b8f83a6c488b82160d4e14d276d7d167a17ea2f45bd699859dc013239c364b4801938d050117042a89bdba38892fe4d9d40b1742c49a9be1f938e5727d54216c71877b71c1f32cc48b80aa95f503988caeaf4065c95bcc9d0e224b28d760d3ec273f339e59677d4bb2a9baf7fb0657d2ac369338c7fe7cd1decc861af85991a027fd10fc8b7d84056564d7b77b86a74a23e9ba4dec35f1767d92dbb6cb9105d7011075f4fdc402980887aefd28a107da082c16dc04b387ad428809c25f9c776b97a0046247"
        );
        $user->setExpires(1670066719);
        $user->setReferer("apodgornyak.kommo.com");

        $userRepository->save($user);

        if (!empty($user->getId())) {
            $result = "Success";
        } else {
            $result = "Error";
        }

        return new TextResponse($result);
    }

}