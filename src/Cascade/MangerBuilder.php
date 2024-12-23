<?php

namespace Handyfit\Framework\Cascade;

use Illuminate\Support\Str;

class MangerBuilder extends Builder
{

    public function boot(): void
    {
        // 初始化 - 载入存根
        if (!$this->init(__CLASS__, 'cascade.manger')) {
            return;
        }

        $this->stubParam('summaries', $this->summariesBuilder());

        $this->put(
            $this->builderUUid(__CLASS__),
            'Manger',
            $this->getCascadeFilepath([])
        );
    }

    private function summariesBuilder(): string
    {
        $summaries = app(Params\Manger::class)->getSummaries();

        $summary = collect($summaries)->map(function (Params\Manger\Summary $summary) {
            $classname = $summary->getClassname();

            $classname = Str::of($classname)->replaceFirst('App\\Cascade\\', '');

            return "$classname::class,";
        });

        if (empty($summary->all())) {
            return 'return collect();';
        }

        $summary = $summary->implode("\n\t");

        return "return collect([\n\t$summary\n]);";
    }

}
