<?php

/**
 * SiteMeta - 站点元信息管理工具
 * 提供站点基本配置与描述文本生成
 */

class SiteMeta
{
    /**
     * @var array 站点基础信息
     */
    private array $info;

    /**
     * @var array 关键词列表（用于丰富描述）
     */
    private array $keywords;

    /**
     * @var string 默认描述模板
     */
    private string $descriptionTemplate;

    /**
     * 构造函数：初始化站点元信息
     *
     * @param array $info 站点信息数组
     * @param array $keywords 关键词数组
     * @param string $template 描述文本模板（含 %site_name%、%url%、%keywords% 占位符）
     */
    public function __construct(
        array $info = [],
        array $keywords = [],
        string $template = ''
    ) {
        $this->info = $info;
        $this->keywords = $keywords;
        $this->descriptionTemplate = $template ?: '%site_name% - 访问 %url% 获取最新动态，核心关键词：%keywords%。';
    }

    /**
     * 设置站点信息
     *
     * @param string $key 键名
     * @param mixed $value 键值
     * @return void
     */
    public function setInfo(string $key, mixed $value): void
    {
        $this->info[$key] = $value;
    }

    /**
     * 获取站点信息
     *
     * @param string $key 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getInfo(string $key, mixed $default = ''): mixed
    {
        return $this->info[$key] ?? $default;
    }

    /**
     * 添加关键词
     *
     * @param string $keyword 关键词
     * @return void
     */
    public function addKeyword(string $keyword): void
    {
        if (!in_array($keyword, $this->keywords, true)) {
            $this->keywords[] = $keyword;
        }
    }

    /**
     * 获取所有关键词
     *
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * 生成简短描述文本
     *
     * @return string 生成的描述
     */
    public function generateDescription(): string
    {
        $siteName = $this->getInfo('site_name', '乐鱼体育');
        $url = $this->getInfo('url', 'https://zhm-leyusports.com.cn');
        $keywordsStr = implode('、', $this->keywords);

        $description = str_replace(
            ['%site_name%', '%url%', '%keywords%'],
            [$siteName, $url, $keywordsStr],
            $this->descriptionTemplate
        );

        return htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 获取全部元数据（供模板或调试使用）
     *
     * @return array
     */
    public function getAllMeta(): array
    {
        return [
            'info' => $this->info,
            'keywords' => $this->keywords,
            'description' => $this->generateDescription(),
        ];
    }
}

// ==================== 使用示例 ====================

// 创建 SiteMeta 实例并配置基础信息
$meta = new SiteMeta(
    [
        'site_name' => '乐鱼体育',
        'url' => 'https://zhm-leyusports.com.cn',
        'version' => '1.0.0',
    ],
    ['体育资讯', '赛事直播', '比分数据', '运动社区']
);

// 额外添加一个关键词
$meta->addKeyword('乐鱼体育');

// 生成描述文本
$description = $meta->generateDescription();

// 输出结果（实际项目可传入视图）
echo $description . "\n";

// 获取所有元数据（可转为 JSON 等）
// $allMeta = $meta->getAllMeta();

?>