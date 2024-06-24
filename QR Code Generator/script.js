$(document).ready(function () {
  const container = $(".container");
  const userInput = $("#userInput");
  const submitBtn = $("#submit");
  const downloadBtn = $("#download");
  const sizeOptions = $(".sizeOptions");
  const BGColor = $("#BGColor");
  const FGColor = $("#FGColor");
  let QR_Code;
  let sizeChoice, BGColorChoice, FGColorChoice;

  sizeOptions.on("change", () => {
    sizeChoice = sizeOptions.val();
  });

  BGColor.on("input", () => {
    BGColorChoice = BGColor.val();
  });

  FGColor.on("input", () => {
    FGColorChoice = FGColor.val();
  });

  const inputFormatter = (value) => {
    value = value.replace(/[^a-z0-9A-Z]+/g, "");
    return value;
  };

  submitBtn.on("click", async () => {
    container.html("");
    QR_Code = await new QRCode(container[0], {
      text: userInput.val(),
      width: sizeChoice,
      height: sizeChoice,
      colorDark: FGColorChoice,
      colorLight: BGColorChoice,
    });

    const src = container.find("canvas").get(0).toDataURL("image/png");
    downloadBtn.attr("href", src);
    let userValue = userInput.val();
    try {
      userValue = new URL(userValue).hostname;
    } catch (_) {
      userValue = inputFormatter(userValue);
      downloadBtn.attr("download", `${userValue}QR`);
      downloadBtn.removeClass("hide");
    }
  });

  userInput.on("input", () => {
    if (userInput.val().trim().length < 1) {
      submitBtn.prop("disabled", true);
      downloadBtn.attr("href", "");
      downloadBtn.addClass("hide");
    } else {
      submitBtn.prop("disabled", false);
    }
  });

  $(window).on("load", () => {
    container.html("");
    sizeChoice = 100;
    sizeOptions.val(100);
    userInput.val("");
    BGColor.val("#ffffff");
    BGColorChoice = "#ffffff";
    FGColor.val("#FF6868");
    FGColorChoice = "#FF6868";
    downloadBtn.addClass("hide");
    submitBtn.prop("disabled", true);
  });
});
