import { Head, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/qc';

type EnvironmentalLog = {
    id: number;
    batch_number: string;
    temperature_celsius: string; // decimal cast serializes as string
    humidity_percent: number;
    logged_at: string;
    created_at: string;
    updated_at: string;
};

type Props = {
    logs: EnvironmentalLog[];
};

const dateTimeFormatter = new Intl.DateTimeFormat('en-ZA', {
    dateStyle: 'medium',
    timeStyle: 'short',
    timeZone: 'Africa/Johannesburg',
});

export default function QcIndex({ logs }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        batch_number: '',
    });

    function submit(e: FormEvent) {
        e.preventDefault();

        post(store.url(), {
            preserveScroll: true,
            onSuccess: () => reset('batch_number'),
        });
    }

    return (
        <>
            <Head title="QC Environmental Logger" />

            <div className="min-h-screen bg-neutral-50 px-4 py-8 dark:bg-neutral-950">
                <div className="mx-auto flex max-w-4xl flex-col gap-8">
                    <header>
                        <h1 className="text-3xl font-bold tracking-tight text-neutral-900 dark:text-neutral-50">
                            Ambient Conditions Logger
                        </h1>
                        <p className="mt-1 text-base text-neutral-600 dark:text-neutral-400">
                            Record current factory temperature and humidity against a batch number.
                        </p>
                    </header>

                    <section className="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                        <form onSubmit={submit} className="flex flex-col gap-4">
                            <div className="grid gap-2">
                                <Label htmlFor="batch_number" className="text-base">
                                    Batch number
                                </Label>
                                <Input
                                    id="batch_number"
                                    name="batch_number"
                                    type="text"
                                    autoFocus
                                    required
                                    placeholder="e.g. BATCH-9942"
                                    value={data.batch_number}
                                    onChange={(e) => setData('batch_number', e.target.value)}
                                    disabled={processing}
                                    className="h-12 text-lg"
                                />
                                <InputError message={errors.batch_number} />
                            </div>

                            <Button
                                type="submit"
                                disabled={processing || data.batch_number.trim() === ''}
                                className="h-12 text-base font-semibold"
                            >
                                {processing && <Spinner />}
                                {processing ? 'Fetching conditions…' : 'Log current conditions'}
                            </Button>
                        </form>
                    </section>

                    <section className="rounded-lg border border-neutral-200 bg-white shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                        <header className="border-b border-neutral-200 px-6 py-4 dark:border-neutral-800">
                            <h2 className="text-xl font-semibold text-neutral-900 dark:text-neutral-50">
                                Logged batches
                            </h2>
                            <p className="mt-0.5 text-sm text-neutral-600 dark:text-neutral-400">
                                {logs.length === 0
                                    ? 'No batches logged yet.'
                                    : `${logs.length} ${logs.length === 1 ? 'entry' : 'entries'}, most recent first.`}
                            </p>
                        </header>

                        {logs.length > 0 && (
                            <div className="overflow-x-auto">
                                <table className="w-full text-left">
                                    <thead className="bg-neutral-50 text-sm uppercase tracking-wide text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400">
                                        <tr>
                                            <th className="px-6 py-3 font-medium">Batch number</th>
                                            <th className="px-6 py-3 font-medium">Temperature</th>
                                            <th className="px-6 py-3 font-medium">Humidity</th>
                                            <th className="px-6 py-3 font-medium">Logged at</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-neutral-200 text-base dark:divide-neutral-800">
                                        {logs.map((log) => (
                                            <tr key={log.id}>
                                                <td className="px-6 py-4 font-mono font-semibold text-neutral-900 dark:text-neutral-100">
                                                    {log.batch_number}
                                                </td>
                                                <td className="px-6 py-4 tabular-nums text-neutral-700 dark:text-neutral-300">
                                                    {Number(log.temperature_celsius).toFixed(1)} °C
                                                </td>
                                                <td className="px-6 py-4 tabular-nums text-neutral-700 dark:text-neutral-300">
                                                    {log.humidity_percent}%
                                                </td>
                                                <td className="px-6 py-4 text-neutral-700 dark:text-neutral-300">
                                                    {dateTimeFormatter.format(new Date(log.logged_at))}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </section>
                </div>
            </div>
        </>
    );
}