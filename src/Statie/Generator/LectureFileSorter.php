<?php declare(strict_types=1);

namespace Pehapkari\Website\Statie\Generator;

use Symplify\Statie\Generator\Contract\ObjectSorterInterface;

final class LectureFileSorter implements ObjectSorterInterface
{
    /**
     * @param LectureFile[] $files
     * @return LectureFile[]
     */
    public function sort(array $files): array
    {
        $activeLectures = [];
        $restOfLectures = [];
        foreach ($files as $key => $file) {
            if ($file->isActive()) {
                $activeLectures[$key] = $file;
            } else {
                $restOfLectures[$key] = $file;
            }
        }

        $activeLectures = $this->sortActiveLecturesByDate($activeLectures);
        $restOfLectures = $this->sortRestOfLecturesByName($restOfLectures);

        return $activeLectures + $restOfLectures;
    }

    /**
     * @param LectureFile[] $activeLectures
     * @return LectureFile[]
     */
    private function sortActiveLecturesByDate(array $activeLectures): array
    {
        uasort($activeLectures, function (LectureFile $firstFile, LectureFile $secondFile) {
            return $secondFile->getDateTime() < $firstFile->getDateTime();
        });

        return $activeLectures;
    }

    /**
     * @param LectureFile[] $restOfLectures
     * @return LectureFile[]
     */
    private function sortRestOfLecturesByName(array $restOfLectures): array
    {
        uasort($restOfLectures, function (LectureFile $firstFile, LectureFile $secondFile) {
            return strcmp($firstFile->getTitle(), $secondFile->getTitle());
        });

        return $restOfLectures;
    }
}
