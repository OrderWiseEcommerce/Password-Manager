<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Closure;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Http\Response;
use Eusonlito\LaravelMeta\Facade as Meta;
use App\Services\Html\Alert;
use App\Services\Request\Response as ResponseService;

abstract class ControllerWebAbstract extends ControllerAbstract
{
    /**
     * @return void
     */
    protected function init(): void
    {
        $this->initDefault();
        $this->initCustom();
    }

    /**
     * @return void
     */
    protected function initDefault(): void
    {
        $this->initViewShare();
        $this->initMetaTitle();
    }

    /**
     * @return void
     */
    protected function initViewShare(): void
    {
        $route = $this->request->route();

        view()->share([
            'ROUTE' => ($route ? $route->getName() : ''),
            'AUTH' => $this->auth,
            'REQUEST' => $this->request,
        ]);
    }

    /**
     * @return void
     */
    protected function initMetaTitle(): void
    {
        Meta::title(__('common.meta.title'));
    }

    /**
     * @return void
     */
    protected function initCustom(): void
    {
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    protected function meta(string $name, string $value): void
    {
        Meta::set($name, $value);
    }

    /**
     * @param string $page
     * @param array $data = []
     * @param ?int $status = null
     *
     * @return \Illuminate\Http\Response
     */
    protected function page(string $page, array $data = [], ?int $status = null): Response
    {
        return response()->view('domains.'.$page, $data, ResponseService::status($status));
    }

    /**
     * @param array $data = []
     *
     * @return void
     */
    final protected function requestMergeWithRow(array $data = []): void
    {
        $this->request->merge($this->requestMergeWithRowData($data) + $this->request->input() + $this->row->toArray());
    }

    /**
     * @param array $data
     *
     * @return array
     */
    final protected function requestMergeWithRowData(array $data): array
    {
        return array_map(static fn ($value) => (array)$value, $data);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    final protected function actionPost(string $name)
    {
        if ($this->request->isMethod('post') && ($this->request->input('_action') === $name)) {
            return call_user_func_array([$this, 'actionCall'], func_get_args());
        }
    }

    /**
     * @param string $name
     * @param string|null $target
     * @param ...$args
     * @return mixed
     */
    final protected function actionCall(string $name, ?string $target = null, ...$args)
    {
        $date_user_stamp = '<div style="font-weight:bold">Edited by ' . Auth::user()->name . ' on ' . date('D j F Y @ H:i') . ' (UTC)</div>';
        $content_spacer = "\n<hr/>\n";

        $r = $this->request->all();

        if (!empty($r['name'])) {
            if ($name == "create") {
                if (!empty($r['payload']['text'])) {
                    $r['payload']['text'] = $date_user_stamp . $r['payload']['text'];
                    $this->request->merge($r);
                }
            }
            else if ($name == "update") {
                if (!empty($r['payload']['new_text'])) {
                    $r['payload']['text'] = $date_user_stamp . $r['payload']['new_text'] . $content_spacer . $r['payload']['text'];
                    $this->request->merge($r);
                }
            }
        }

        try {
            return call_user_func_array([$this, $target ?: $name], $args);
        } catch (Throwable $e) {
            return Alert::exception($this->request, $e);
        }
    }

    /**
     * @param \Closure $closure
     *
     * @return mixed
     */
    final protected function actionCallClosure(Closure $closure)
    {
        try {
            return $closure();
        } catch (Throwable $e) {
            return Alert::exception($this->request, $e);
        }
    }

    /**
     * @param string $status
     * @param string $message
     *
     * @return mixed
     */
    final protected function sessionMessage(string $status, string $message)
    {
        return Alert::{$status}($message);
    }
}
