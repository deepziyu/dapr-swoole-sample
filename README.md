# Dapr Swoole Sample

[中文][En]

### 是个啥
这是 [Dapr](https://github.com/dapr) 示例，用 PHP 编写，运行在 Kubernetes 集群上。

启动原理请查看 [https://github.com/dapr/samples/blob/master/2.hello-kubernetes/README.md](https://github.com/dapr/samples/blob/master/2.hello-kubernetes/README.md)

### 实践

#### 1、修改你的代码

填上你的 docker-registry 地址：
- makefile 文件的的 SAMPLE_REGISTRY 变量
- deploy/*.yaml 文件的 YOUR REGISTRY && YOUR REGISTRY LOGIN SECRETS

#### 2、构建 docker image 

- 执行 make
- 执行 make push

成功后你的镜像仓库里应该有相应的镜像了，去看看。

#### 3、部署到 Kubernetes 集群上

请参照 [余下步骤](https://github.com/dapr/samples/blob/master/2.hello-kubernetes/README.md#step-1---setup-dapr-on-your-kubernetes-cluster) 即可。

