<?php

namespace App\Actions\Recipient;

use App\Models\Campaign;
use App\Models\File;
use App\Models\Recipient;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\SimpleExcel\SimpleExcelReader;

class Create
{
    use AsAction;

    public Campaign $campaign;
    public File $file;
    public SimpleExcelReader $rows;

    public function handle($assignments)
    {
        $this->rows->getRows()->each(function(array $rowProperties) use ($assignments) {
            $recipient = [];
            
            foreach($assignments as $key => $assignment)
            {
                switch ($assignment) {
                    case 'skip':
                        break;
                    case 'name':
                        $recipient['name'] = $rowProperties[$key];
                        break;
                    case 'group_id':
                        $group = $this->campaign->groups()->firstOrCreate(['name' => $rowProperties[$key]]);
                        $recipient['group_id'] = $group->id;
                        break;
                    case 'external_id':
                        $recipient['external_id'] = $rowProperties[$key];
                        break;
                    case 'meta':
                        $recipient['meta'][$key] = $rowProperties[$key];
                        break;
                }
            }

            $newRecord = $this->campaign->recipients()->create($recipient);
            $newRecord->setMeta($recipient['meta']);
            $newRecord->save();
        });
    }

    public function asController(ActionRequest $request, Campaign $campaign)
    {
        $this->campaign = $campaign;
        if($request->has('file'))
        {
            try {
                $this->file = File::find($request->file);
            } catch (\Throwable $th) {
                return redirect(route('error', 1002));
            }
            $this->rows = SimpleExcelReader::create(Storage::path('recipients/' . $this->file->file_path));
            $headerKeys = array_values($this->rows->headersToSnakeCase()->getHeaders());
            $assignments = $request->only($headerKeys);

            $this->handle($assignments);

            $this->file->update(['status' => 'complete']);
            return redirect(route('campaign.show', $campaign));
        }

        return redirect(route('error', 1001));
    }
}
