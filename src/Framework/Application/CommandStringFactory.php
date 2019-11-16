<?php
declare(strict_types=1);

namespace App\Framework\Application;

class CommandStringFactory
{
    /**
     * @param string $tag
     * @param string $dockerFile
     * @return string
     */
    public function getBuildCommandStr(string $tag, string $dockerFile): string
    {
        return
            "docker image build -t {$tag} {$dockerFile}" ;
    }

    /**
     * @param string $containerName
     * @param string $tag
     * @return string
     */
    public function getRunCommandStr(string $containerName, string $tag): string
    {
        // docker image build -t {tag} .
        // docker container run --publish {out_port}:{in_port} --detach --name {container_name} {tag}
        return
            "docker container run --detach --name {$containerName} {$tag}" ;
    }
}
