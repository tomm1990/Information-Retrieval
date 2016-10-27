//navigator.webkitPersistentStorage.requestQuota(1024*1024, function() {
// window.webkitRequestFileSystem(window.PERSISTENT , 1024*1024, SaveDatFileBro);
//})



                    var openFile = function(event) {
                        window.requestFileSystem = window.requestFileSystem || window.webkitRequestFileSystem;
                        window.requestFileSystem(window.TEMPORARY, 5 * 1024 * 1024, initFS);

                        function SaveDatFileBro(localstorage) {
                          localstorage.root.getFile("galina.txt", {create: true});
                        }

                        function initFS(localstorage) {
                            alert("Welcome to Filesystem! It's showtime :)"); // Just to check if everything is OK :)


                            localstorage.root.getFile("galina.txt", {create: true});

//                            fs.root.getDirectory('../xampp/htdocs/Retrieval/Retrieval/datadata', { create: true }, function(dirEntry) {
//                               console.log("trying to loading text file =>"+fs.root.dir);
//
////                                var input = event.target;
////
////                                var reader = new FileReader();
////                                reader.onload = function(){
////                                    var text = reader.result;
////                                    console.log(reader.result.substring(0, 200));
////                                    SaveDatFileBro(fs);
////
////                                };
////
////                            reader.readAsText(input.files[0]);
////                                    alert('You have just created the ' + dirEntry.name + ' directory.');
//                            });
//                            //alert('the root is : ' + fs.root.name + ' directory.');
//                              fs.root.getFile('gal.txt', {create: true}, function(fileEntry) {
//                                alert('succesfully');
//                              }, errorHandler);
                        }

                    };
//
//                    	function saveTextAsFile(textToWrite)
//                        {
//                            var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
//                            var fileNameToSaveAs = "file5";
//                            console.log(fileNameToSaveAs);
//                            if (fileNameToSaveAs == ""){
//                                fileNameToSaveAs = Date();
//                            }
//
//                            var downloadLink = document.createElement("a");
//                            downloadLink.download = fileNameToSaveAs;
//                            downloadLink.innerHTML = "Download File";
//                            if (window.webkitURL != null)
//                            {
//                                // Chrome allows the link to be clicked
//                                // without actually adding it to the DOM.
//                                downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
//                            }
//                            else
//                            {
//                                // Firefox requires the link to be added to the DOM
//                                // before it can be clicked.
//                                downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
//                                downloadLink.onclick = destroyClickedElement;
//                                downloadLink.style.display = "none";
//                                document.body.appendChild(downloadLink);
//                            }
//
//                            downloadLink.click();
//                        }
//
//                        function destroyClickedElement(event)
//                        {
//                            document.body.removeChild(event.target);
//                        }
//
//                        function loadFileAsText()
//                        {
//                            var fileToLoad = document.getElementById("fileToLoad").files[0];
//
//                            var fileReader = new FileReader();
//                            fileReader.onload = function(fileLoadedEvent)
//                            {
//                                var textFromFileLoaded = fileLoadedEvent.target.result;
//                                document.getElementById("inputTextToSave").value = textFromFileLoaded;
//                            };
//                            fileReader.readAsText(fileToLoad, "UTF-8");
//                        }
//
//                    function SaveDatFileBro(localstorage) {
//                      localstorage.root.getFile("file5.txt", {}, function(DatFile) {
//                        localstorage.root.getDirectory("data/", {}, function(DatFolder) {
//                          datei.moveTo(DatFolder);
//                        });
//                      });
//                    }
