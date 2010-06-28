# WARNING
-----------------------------
This is a proof-of-concept requiring modified OpenVBX code to run. Please treat
it as such. Things may break, future updates may not apply. It it my intention 
to make this compatible with the official release once [it is possible][0].

[0]: http://getsatisfaction.com/openvbx/topics/access_plugin_without_login

# Click-To-Flow for OpenVBX
-----------------------------
Plugin for [OpenVBX][1] allows a flow to be initiated buy a form POST. Currently
requires modified OpenVBX source from my [OpenVBX fork][2], allowing plugins to
be accessed by unauthenticated requests.

[1]: http://openvbx.org/
[2]: http://github.com/tjlytle/OpenVBX

# Install
-----------------------------
From the [Plugin][3] section of the OpenVBX site.

1. Download the plugin to /plugins and unzip
2. Launch your OpenVBX installation
3. Navigate to Settings in the Admin section
4. Select the Plugins tab
5. Select the "Configure" link next to your plugin to ensure installation was successful, and configure any settings

You will also need to patch your OpenVBX installation with [this commit][3].

[3]: http://github.com/tjlytle/OpenVBX/commit/bcf3919948862a9342e917163b41fbdb912299ac

# License
-----------------------------
See [LICENSE](http://github.com/tjlytle/OpenVBX-Directory/blob/master/LICENSE).
