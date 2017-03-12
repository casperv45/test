<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * flowers
 *
 * @ORM\Table(name="flowers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\flowersRepository")
 */
class flowers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="flowerCode", type="string", length=15, nullable=true, unique=true)
     */
    private $flowerCode;

    /**
     * @var string
     *
     * @ORM\Column(name="opslagPath", type="string", length=255, nullable=true)
     */
    private $opslagPath;

    /**
     * @var float
     *
     * @ORM\Column(name="prijs", type="float", nullable=true)
     */
    private $prijs;

     /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->opslagPath = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    public function getAbsolutePath()
    {
        return null === $this->opslagPath
            ? null
            : $this->getUploadRootDir().'/'.$this->opslagPath;
    }

    public function getWebPath()
    {
        return null === $this->opslagPath
            ? null
            : $this->getUploadDir().'/'.$this->opslagPath;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set flowerCode
     *
     * @param string $flowerCode
     *
     * @return flowers
     */
    public function setFlowerCode($flowerCode)
    {
        $this->flowerCode = $flowerCode;

        return $this;
    }

    /**
     * Get flowerCode
     *
     * @return string
     */
    public function getFlowerCode()
    {
        return $this->flowerCode;
    }

    /**
     * Set opslagPath
     *
     * @param string $opslagPath
     *
     * @return flowers
     */
    public function setOpslagPath($opslagPath)
    {
        $this->opslagPath = $opslagPath;

        return $this;
    }

    /**
     * Get opslagPath
     *
     * @return string
     */
    public function getOpslagPath()
    {
        return $this->opslagPath;
    }

    /**
     * Set prijs
     *
     * @param float $prijs
     *
     * @return flowers
     */
    public function setPrijs($prijs)
    {
        $this->prijs = $prijs;

        return $this;
    }

    /**
     * Get prijs
     *
     * @return float
     */
    public function getPrijs()
    {
        return $this->prijs;
    }

}

